<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Plugin\Indexer\Product\Save;

use MagePrakash\ProductAttachment\Model\Indexer\Product\ProductRuleIndexer;
use Magento\Framework\Indexer\IndexerRegistry;

class ApplyRules
{
    /**
     * @var ProductRuleIndexer
     */
    protected $productRuleIndexer;

    /**
     * @var IndexerRegistry
     */
    protected $indexerRegistry;

    /**
     * @param IndexerRegistry $indexerRegistry
     * @param ProductRuleIndexer $productRuleIndexer
     */
    public function __construct(
        IndexerRegistry $indexerRegistry,
        ProductRuleIndexer $productRuleIndexer
    ) {
        $this->indexerRegistry = $indexerRegistry;
        $this->productRuleIndexer = $productRuleIndexer;
    }

    /**
     * Apply catalog rules after product resource model save
     *
     * @param \Magento\Catalog\Model\ResourceModel\Product $subject
     * @param \Magento\Catalog\Model\ResourceModel\Product $productResource
     * @param \Magento\Framework\Model\AbstractModel $product
     * @return \Magento\Catalog\Model\ResourceModel\Product
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterSave(
        \Magento\Catalog\Model\ResourceModel\Product $subject,
        \Magento\Catalog\Model\ResourceModel\Product $productResource,
        \Magento\Framework\Model\AbstractModel $product
    ) {
        $indexer = $this->indexerRegistry->get('mageprakash_productAttachment_product');
        if (!$product->getIsMassupdate() && ($indexer->isScheduled() == false)) {
            $this->productRuleIndexer->executeRow($product->getId());
        }
        return $productResource;
    }
}
