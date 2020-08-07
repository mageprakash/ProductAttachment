<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Model\Data;

use MagePrakash\ProductAttachment\Api\Data\AttachmentItemsInterface;

class AttachmentItems extends \Magento\Framework\Api\AbstractExtensibleObject implements AttachmentItemsInterface
{

    /**
     * Get items
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface[]
     */
    public function getItems()
    {
        return $this->_get(self::ITEMS);
    }

    /**
     * Set items
     * @param \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface[] $item
     * @return $this
     */
    public function setItems($items)
    {
        return $this->setData(self::ITEMS, $items);
    }
}
