<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface AttachmentRepositoryInterface
{

    /**
     * Save attachment
     * @param \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface $attachment
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface $attachment
    );

    /**
     * Retrieve productId
     * @param int $productId
     * @param int $customerGroupId
     * @param int $storeId          
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentItemInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getAttachmentsByProductId($productId,$customerGroupId,$storeId);

    /**
     * Retrieve attachment
     * @param string $attachmentId
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($attachmentId);

 

    /**
     * Retrieve attachment matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete attachment
     * @param \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface $attachment
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface $attachment
    );

    /**
     * Delete attachment by ID
     * @param string $attachmentId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($attachmentId);
}
