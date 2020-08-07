<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Api\Data;

interface AttachmentInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    const FILENAME        = 'filename';
    const STORE_IDS       = 'store_ids';
    const SIZE            = 'size';
    const IS_ENABLE       = 'is_enable';
    const POSITION        = 'position';
    const ATTACHMENT_ID   = 'attachment_id';
    const FILEPATH        = 'filepath';
    const TYPE            = 'type';
    const CUSTOMER_GROUPS = 'customer_groups';
    const ICON_IMAGE      = 'icon_image';
    const PRODUCT_IDS     = 'product_ids';
    const ICON_ID         = 'icon_id'; 

    /**
     * Get attachment_id
     * @return string|null
     */
    public function getAttachmentId();

    /**
     * Set attachment_id
     * @param string $attachmentId
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface
     */
    public function setAttachmentId($attachmentId);

    /**
     * Get filename
     * @return string|null
     */
    public function getFilename();

    /**
     * Set filename
     * @param string $filename
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface
     */
    public function setFilename($filename);

    /**
     * Get iconId
     * @return int
     */
    public function getIconId();

    /**
     * Set iconId
     * @param int $iconId
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface
     */
    public function setIconId($iconId);

    /**
     * Get iconImage
     * @return  string|null
     */
    public function getIconImage();

    /**
     * Set iconImage
     * @param string $iconImage
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface
     */
    public function setIconImage($iconImage);    

    /**
     * Get is_enable
     * @return string|null
     */
    public function getIsEnable();

    /**
     * Set is_enable
     * @param string $isEnable
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface
     */
    public function setIsEnable($isEnable);

    /**
     * Get customer_groups
     * @return string|null
     */
    public function getCustomerGroups();

    /**
     * Set customer_groups
     * @param string $customerGroups
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface
     */
    public function setCustomerGroups($customerGroups);

    /**
     * Get store_ids
     * @return string|null
     */
    public function getStoreIds();

    /**
     * Set store_ids
     * @param string $storeIds
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface
     */
    public function setStoreIds($storeIds);

    /**
     * Get position
     * @return string|null
     */
    public function getPosition();

    /**
     * Set position
     * @param string $position
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface
     */
    public function setPosition($position);

    /**
     * Get filepath
     * @return string|null
     */
    public function getFilepath();

    /**
     * Set filepath
     * @param file $filepath
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface
     */
    public function setFilepath($filepath);

    /**
     * Get size
     * @return string|null
     */
    public function getSize();

    /**
     * Set size
     * @param string $size
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface
     */
    public function setSize($size);

    /**
     * Get type
     * @return string|null
     */
    public function getType();

    /**
     * Set type
     * @param string $type
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface
     */
    public function setType($type);

    /**
     * Get type
     * @return string|null
     */
    public function getProductIds();

    /**
     * Set type
     * @param string $type
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface
     */
    public function setProductIds($productIds);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \MagePrakash\ProductAttachment\Api\Data\AttachmentExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \MagePrakash\ProductAttachment\Api\Data\AttachmentExtensionInterface $extensionAttributes
    );
}
