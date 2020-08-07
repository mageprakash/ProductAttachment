<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Model\Indexer;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use MagePrakash\ProductAttachment\Model\Attachment;
use MagePrakash\ProductAttachment\Model\AttachmentFactory;
use MagePrakash\ProductAttachment\Model\ResourceModel\Attachment\CollectionFactory as AttachmentCollectionFactory;
use MagePrakash\ProductAttachment\Model\Indexer\IndexBuilder\ProductLoader;
use Magento\Catalog\Model\Product;

class IndexBuilder
{
    /**
     * @var int
     */
    protected $batchCount;

    /**
     * @var string
     */
    protected $indexTableName;

    /**
     * @var AdapterInterface
     */
    protected $connection;

    /**
     * @var ResourceConnection
     */
    protected $resource;

    /**
     * @var AttachmentCollectionFactory
     */
    protected $AttachmentCollectionFactory;

    /**
     * @var AttachmentFactory
     */
    protected $AttachmentFactory;

    /**
     * @var ProductLoader
     */
    private $productLoader;

    /**
     * @param ResourceConnection $resource
     * @param AttachmentCollectionFactory $AttachmentCollectionFactory
     * @param AttachmentFactory $Attachmentactory
     * @param ProductLoader $productLoader
     */
    public function __construct(
        ResourceConnection $resource,
        AttachmentCollectionFactory $AttachmentCollectionFactory,
        AttachmentFactory $AttachmentFactory,
        ProductLoader $productLoader
    )
    {
        $this->resource = $resource;
        $this->connection = $resource->getConnection();
        $this->AttachmentCollectionFactory = $AttachmentCollectionFactory;
        $this->AttachmentFactory = $AttachmentFactory;
        $this->productLoader = $productLoader;
        $this->batchCount = 1000;
        $this->indexTableName = 'mageprakash_productattachment_attachment_rule_idx';
    }

    /**
     * @return int
     */
    public function getBatchCount()
    {
        return $this->batchCount;
    }

    /**
     * @return string
     */
    public function getIndexTableName()
    {
        return $this->indexTableName;
    }

    /**
     * @return array
     */
    protected function getAllAttachment()
    {
        return $this->AttachmentCollectionFactory->create();
    }

    /**
     * @throws \Exception
     * @return void
     */
    public function fullReindex()
    {

        $indexTableName = $this->getIndexTableName();
        $this->connection->truncateTable($this->resource->getTableName($indexTableName));
        try {
            foreach ($this->getAllAttachment() as $productAttachment) {
                $this->executeIndexForAttachment($productAttachment);
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param array $ids
     * @throws \Exception
     */
    public function reindexRule($ids)
    {
        $ids = array_unique($ids);
        $this->connection->beginTransaction();
        try {
            $this->cleanByIds($ids);
            foreach ($ids as $productAttachmentId) {
                $productAttachment = $this->AttachmentFactory->create()->load($productAttachmentId);
                $this->executeIndexForAttachment($productAttachment);
            }
            $this->connection->commit();
        } catch (\Exception $e) {
            $this->connection->rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param array $ids
     * @return void
     */
    protected function cleanByIds($ids)
    {
        $query = $this->connection->deleteFromSelect(
            $this->connection
                ->select()
                ->from($this->resource->getTableName($this->getIndexTableName()), 'rule_id')
                ->distinct()
                ->where('rule_id IN (?)', $ids),
            $this->resource->getTableName($this->getIndexTableName())
        );
        $this->connection->query($query);
    }

    /**
     * @param array $ids
     * @return void
     */
    protected function cleanByProductIds($ids)
    {
        $query = $this->connection->deleteFromSelect(
            $this->connection
                ->select()
                ->from($this->resource->getTableName($this->getIndexTableName()), 'product_id')
                ->distinct()
                ->where('product_id IN (?)', $ids),
            $this->resource->getTableName($this->getIndexTableName())
        );
        $this->connection->query($query);
    }

    /**
     * @param \WeltPixel\Attachment\Model\Attachment $productAttachment
     * @return bool
     */
    protected function executeIndexForAttachment($productAttachment)
    {

        $isProductAttachmentEnabled = $productAttachment->getIsEnable();
        if (!$isProductAttachmentEnabled) {
            return false;
        }

        $rows = [];
        $ruleId = $productAttachment->getAttachmentId();
        $indexTableName = $this->getIndexTableName();

        if($productAttachment->getAttachmentScope()== 2 || $productAttachment->getAttachmentScope() == 3){

        $productIds = $productAttachment->getMatchingProductIds();

        foreach ($productIds as $productIdDetails) {
            foreach ($productIdDetails as $storeId => $productId) {
                $rows[] = [
                    'rule_id' => $ruleId,
                    'product_id' => $productId,
                    'store_id' => $storeId
                ];

                if (count($rows) == $this->batchCount) {
                    $this->connection->insertMultiple($this->resource->getTableName($indexTableName), $rows);
                    $rows = [];
                    }
                }
            }
        }
        if (!empty($rows)) {
            $this->connection->insertMultiple($this->resource->getTableName($indexTableName), $rows);
        }

        return true;
    }

    /**
     * @param array $ids
     */
    /**
     * @param array $ids
     * @throws \Exception
     */
    public function reindexProductRule($ids)
    {
        $ids = array_unique($ids);

        $this->connection->beginTransaction();
        try {
            $this->cleanByProductIds($ids);
            $products = $this->productLoader->getProducts($ids);
            foreach ($this->getAllAttachment() as $productAttachment) {
                if($productAttachment)
                {
                    if($productAttachment->getAttachmentScope()== 2 || $productAttachment->getAttachmentScope() == 3)
                    {
                        foreach ($products as $product) {
                            $this->applyRule($productAttachment, $product);
                        }
                    }
                }
            }
            $this->connection->commit();
        } catch (\Exception $e) {
            $this->connection->rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param Attachment $productAttachment
     * @param Product $product
     * @return $this
     * @throws \Exception
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function applyRule(Attachment $productAttachment, $product)
    {
        $ruleId = $productAttachment->getAttachmentId();
        $productId = $product->getId();
        $storeIds = $productAttachment->getAllStoreIdsAssigned();
        $indexTableName = $this->getIndexTableName();

        $this->connection->delete(
            $this->resource->getTableName($indexTableName),
            [
                $this->connection->quoteInto('rule_id = ?', $ruleId),
                $this->connection->quoteInto('product_id = ?', $productId)
            ]
        );

        $rows = [];
        try {
            foreach ($storeIds as $storeId) {
                $product->setStoreId($storeId);
                if (!$productAttachment->validate($product)) {
                    continue;
                }

                $rows[] = [
                    'rule_id' => $ruleId,
                    'product_id' => $productId,
                    'store_id' => $storeId
                ];

                if (count($rows) == $this->batchCount) {
                    $this->connection->insertMultiple($this->resource->getTableName($indexTableName), $rows);
                    $rows = [];
                }
            }

            if (!empty($rows)) {
                $this->connection->insertMultiple($this->resource->getTableName($indexTableName), $rows);
            }
        } catch (\Exception $e) {
            throw $e;
        }

        return $this;
    }
}
