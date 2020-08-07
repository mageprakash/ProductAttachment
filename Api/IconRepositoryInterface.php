<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface IconRepositoryInterface
{
    /**
     * Save icon
     * @param \MagePrakash\ProductAttachment\Api\Data\IconInterface $icon
     * @return \MagePrakash\ProductAttachment\Api\Data\IconInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \MagePrakash\ProductAttachment\Api\Data\IconInterface $icon
    );

    /**
     * Retrieve icon
     * @param string $iconId
     * @return \MagePrakash\ProductAttachment\Api\Data\IconInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($iconId);

    /**
     * Retrieve icon matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \MagePrakash\ProductAttachment\Api\Data\IconSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete icon
     * @param \MagePrakash\ProductAttachment\Api\Data\IconInterface $icon
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \MagePrakash\ProductAttachment\Api\Data\IconInterface $icon
    );

    /**
     * Delete icon by ID
     * @param string $iconId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($iconId);
}
