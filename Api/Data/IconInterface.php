<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Api\Data;

interface IconInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const IMAGE = 'image';
    const ICON_ID = 'icon_id';
    const FILETYPE = 'filetype';
    const IS_ACTIVE = 'is_active';
    const ICON_EXTENSION = 'icon_extension';

    /**
     * Get icon_id
     * @return string|null
     */
    public function getIconId();

    /**
     * Set icon_id
     * @param string $iconId
     * @return \MagePrakash\ProductAttachment\Api\Data\IconInterface
     */
    public function setIconId($iconId);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \MagePrakash\ProductAttachment\Api\Data\IconExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \MagePrakash\ProductAttachment\Api\Data\IconExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \MagePrakash\ProductAttachment\Api\Data\IconExtensionInterface $extensionAttributes
    );

    /**
     * Get filetype
     * @return string|null
     */
    public function getFiletype();

    /**
     * Set filetype
     * @param string $filetype
     * @return \MagePrakash\ProductAttachment\Api\Data\IconInterface
     */
    public function setFiletype($filetype);

    /**
     * Get image
     * @return string|null
     */
    public function getImage();

    /**
     * Set image
     * @param string $image
     * @return \MagePrakash\ProductAttachment\Api\Data\IconInterface
     */
    public function setImage($image);

    /**
     * Get is_active
     * @return string|null
     */
    public function getIsActive();

    /**
     * Set is_active
     * @param string $isActive
     * @return \MagePrakash\ProductAttachment\Api\Data\IconInterface
     */
    public function setIsActive($isActive);

    /**
     * Get icon_extension
     * @return string|null
     */
    public function getIconExtension();

    /**
     * Set icon_extension
     * @param string $iconExtension
     * @return \MagePrakash\ProductAttachment\Api\Data\IconInterface
     */
    public function setIconExtension($iconExtension);
}
