<?php declare(strict_types=1);


namespace MagePrakash\ProductAttachment\Api;

use Magento\Framework\Api\SearchCriteriaInterface;


interface AttachmentRuleIdxRepositoryInterface
{

    /**
     * Save attachmentRuleIdx
     * @param \MagePrakash\ProductAttachment\Api\Data\AttachmentRuleIdxInterface $attachmentRuleIdx
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentRuleIdxInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \MagePrakash\ProductAttachment\Api\Data\AttachmentRuleIdxInterface $attachmentRuleIdx
    );

    /**
     * Retrieve attachmentRuleIdx
     * @param string $attachmentruleidxId
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentRuleIdxInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($attachmentruleidxId);

    /**
     * Retrieve attachmentRuleIdx matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentRuleIdxSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete attachmentRuleIdx
     * @param \MagePrakash\ProductAttachment\Api\Data\AttachmentRuleIdxInterface $attachmentRuleIdx
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \MagePrakash\ProductAttachment\Api\Data\AttachmentRuleIdxInterface $attachmentRuleIdx
    );

    /**
     * Delete attachmentRuleIdx by ID
     * @param string $attachmentruleidxId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($attachmentruleidxId);
}

