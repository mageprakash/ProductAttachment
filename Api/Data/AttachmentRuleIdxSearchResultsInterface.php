<?php declare(strict_types=1);


namespace MagePrakash\ProductAttachment\Api\Data;


interface AttachmentRuleIdxSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get attachmentRuleIdx list.
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentRuleIdxInterface[]
     */
    public function getItems();

    /**
     * Set rule_id list.
     * @param \MagePrakash\ProductAttachment\Api\Data\AttachmentRuleIdxInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

