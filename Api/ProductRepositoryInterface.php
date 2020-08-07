<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface ProductRepositoryInterface
{

    /**
     * Save product
     * @param \MagePrakash\ProductAttachment\Api\Data\ProductInterface $product
     * @return \MagePrakash\ProductAttachment\Api\Data\ProductInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \MagePrakash\ProductAttachment\Api\Data\ProductInterface $product
    );

    /**
     * Retrieve product
     * @param string $productId
     * @return \MagePrakash\ProductAttachment\Api\Data\ProductInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($productId);

    /**
     * Retrieve product matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \MagePrakash\ProductAttachment\Api\Data\ProductSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete product
     * @param \MagePrakash\ProductAttachment\Api\Data\ProductInterface $product
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \MagePrakash\ProductAttachment\Api\Data\ProductInterface $product
    );

    /**
     * Delete product by ID
     * @param string $productId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($productId);
}
