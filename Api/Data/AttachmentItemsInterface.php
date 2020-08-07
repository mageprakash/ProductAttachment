<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Api\Data;

interface AttachmentItemsInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    const ITEMS  = 'items';

    /**
     * Get items
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface[]
     */
    public function getItems();

    /**
     * Set items
     * @param \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface[] $item
     * @return $this
     */
    public function setItems($item);
}
