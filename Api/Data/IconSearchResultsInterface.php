<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Api\Data;

interface IconSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get icon list.
     * @return \MagePrakash\ProductAttachment\Api\Data\IconInterface[]
     */
    public function getItems();

    /**
     * Set icon_id list.
     * @param \MagePrakash\ProductAttachment\Api\Data\IconInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
