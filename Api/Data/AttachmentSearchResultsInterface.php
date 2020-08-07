<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Api\Data;

interface AttachmentSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get attachment list.
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface[]
     */
    public function getItems();

    /**
     * Set filename list.
     * @param \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
