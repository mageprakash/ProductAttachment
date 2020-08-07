<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Plugin\Indexer;

use MagePrakash\ProductAttachment\Model\Attachment;
use Magento\Framework\Indexer\IndexerRegistry;
use MagePrakash\ProductAttachment\Model\Indexer\Rule\RuleProductIndexer;

class ReindexRuleIdProducts
{
    /**
     * @var IndexerRegistry
     */
    protected $indexerRegistry;

    /**
     * @var RuleProductIndexer
     */
    protected $productAttachmentRuleIndexer;

    /**
     * ReindexRuleIdProducts constructor.
     * @param IndexerRegistry $indexerRegistry
     * @param RuleProductIndexer $productAttachmentRuleIndexer
     */
    public function __construct(
        IndexerRegistry $indexerRegistry,
        RuleProductIndexer $productAttachmentRuleIndexer
    )
    {
        $this->indexerRegistry = $indexerRegistry;
        $this->productAttachmentRuleIndexer = $productAttachmentRuleIndexer;
    }

    /**
     * @param Attachment $subject
     * @param Attachment $result
     * @return Attachment
     */
    public function afterAfterSave(Attachment $subject, Attachment $result) {

        if($result->getAttachmentScope() == 2 || $result->getAttachmentScope() == 3)
        {
            $ruleId = $subject->getId();
            $indexer = $this->indexerRegistry->get('mageprakash_productAttachment_rule');
            if($indexer->isScheduled() == false){
                $this->productAttachmentRuleIndexer->executeRow($ruleId);
            }
        }
        return $result;
    }
}
