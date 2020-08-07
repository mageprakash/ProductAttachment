<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Model\Data;

use MagePrakash\ProductAttachment\Api\Data\AttachmentInterface;

class Attachment extends \Magento\Framework\Api\AbstractExtensibleObject implements AttachmentInterface
{

    /**
     * Get attachment_id
     * @return string|null
     */
    public function getAttachmentId()
    {
        return $this->_get(self::ATTACHMENT_ID);
    }

    /**
     * Set attachment_id
     * @param string $attachmentId
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface
     */
    public function setAttachmentId($attachmentId)
    {
        return $this->setData(self::ATTACHMENT_ID, $attachmentId);
    }

    /**
     * Get filename
     * @return string|null
     */
    public function getFilename()
    {
        return $this->_get(self::FILENAME);
    }

    /**
     * Set filename
     * @param string $filename
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface
     */
    public function setFilename($filename)
    {
        return $this->setData(self::FILENAME, $filename);
    }

    /**
     * Get iconId
     * @return int
     */
    public function getIconId()
    {
        return $this->_get(self::ICON_ID);
    }

    /**
     * Set iconId
     * @param int $iconId
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface
     */
    public function setIconId($iconId)
    {
        return $this->setData(self::ICON_ID, $iconId);
    }

    /**
     * Get iconImage
     * @return string|null
     */
    public function getIconImage()
    {
        return $this->_get(self::ICON_IMAGE);
    }

    /**
     * Set iconImage
     * @param string $iconImage
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface
     */
    public function setIconImage($iconImage)
    {
        return $this->setData(self::ICON_IMAGE, $iconImage);
    }

    /**
     * Get is_enable
     * @return string|null
     */
    public function getIsEnable()
    {
        return $this->_get(self::IS_ENABLE);
    }

    /**
     * Set is_enable
     * @param string $isEnable
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface
     */
    public function setIsEnable($isEnable)
    {
        return $this->setData(self::IS_ENABLE, $isEnable);
    }

    /**
     * Get customer_groups
     * @return string|null
     */
    public function getCustomerGroups()
    {
        return $this->_get(self::CUSTOMER_GROUPS);
    }


    /**
     * @param string $customerGroups
     * @return AttachmentInterface|Attachment
     */
    public function setCustomerGroups($customerGroups)
    {
        return $this->setData(self::CUSTOMER_GROUPS, $customerGroups);
    }

    /**
     * Get store_ids
     * @return string|null
     */
    public function getStoreIds()
    {
        return $this->_get(self::STORE_IDS);
    }

    /**
     * Set store_ids
     * @param string $storeIds
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface
     */
    public function setStoreIds($storeIds)
    {
        return $this->setData(self::STORE_IDS, $storeIds);
    }

    /**
     * Get position
     * @return string|null
     */
    public function getPosition()
    {
        return $this->_get(self::POSITION);
    }

    /**
     * Set position
     * @param string $position
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface
     */
    public function setPosition($position)
    {
        return $this->setData(self::POSITION, $position);
    }

    /**
     * Get filepath
     * @return string|null
     */
    public function getFilepath()
    {
        return $this->_get(self::FILEPATH);
    }

    /**
     * Set filepath
     * @param file $filepath
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface
     */
    public function setFilepath($filepath)
    {
        return $this->setData(self::FILEPATH, $filepath);
    }

    /**
     * Get size
     * @return string|null
     */
    public function getSize()
    {
        return $this->_get(self::SIZE);
    }

    /**
     * Set size
     * @param string $size
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface
     */
    public function setSize($size)
    {
        return $this->setData(self::SIZE, $size);
    }

    /**
     * Get type
     * @return string|null
     */
    public function getType()
    {
        return $this->_get(self::TYPE);
    }

    /**
     * Set mine_type
     * @param string $type
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface
     */
    public function setType($type)
    {
        return $this->setData(self::TYPE, $type);
    }

    /**
     * Get type
     * @return string|null
     */
    public function getProductIds()
    {
        return $this->_get(self::PRODUCT_IDS);
    }

    /**
     * Set productIds
     * @param string $productIds
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface
     */
    public function setProductIds($productIds)
    {
        return $this->setData(self::PRODUCT_IDS, $productIds);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \MagePrakash\ProductAttachment\Api\Data\AttachmentExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \MagePrakash\ProductAttachment\Api\Data\AttachmentExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
