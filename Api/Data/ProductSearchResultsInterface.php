<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Api\Data;

interface ProductSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get product list.
     * @return \MagePrakash\ProductAttachment\Api\Data\ProductInterface[]
     */
    public function getItems();

    /**
     * Set product_id list.
     * @param \MagePrakash\ProductAttachment\Api\Data\ProductInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
