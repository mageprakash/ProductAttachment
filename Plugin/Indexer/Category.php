<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Plugin\Indexer;

use MagePrakash\ProductAttachment\Model\Indexer\Product\ProductRuleIndexer;
use Magento\Framework\Indexer\IndexerRegistry;

class Category
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
     * @param \Magento\Catalog\Model\Category $subject
     * @param \Magento\Catalog\Model\Category $result
     * @return \Magento\Catalog\Model\Category
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterSave(
        \Magento\Catalog\Model\Category $subject,
        \Magento\Catalog\Model\Category $result
    ) {
        /** @var \Magento\Catalog\Model\Category $result */
        $productIds = $result->getChangedProductIds();
        $indexer = $this->indexerRegistry->get('mageprakash_productAttachment_product');
        if (!empty($productIds) && ($indexer->isScheduled() == false)) {
            $this->productRuleIndexer->executeRow($productIds);
        }
        return $result;
    }
}
