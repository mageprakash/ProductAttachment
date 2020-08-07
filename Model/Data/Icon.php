<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Model\Data;

use MagePrakash\ProductAttachment\Api\Data\IconInterface;

class Icon extends \Magento\Framework\Api\AbstractExtensibleObject implements IconInterface
{

    /**
     * Get icon_id
     * @return string|null
     */
    public function getIconId()
    {
        return $this->_get(self::ICON_ID);
    }

    /**
     * Set icon_id
     * @param string $iconId
     * @return \MagePrakash\ProductAttachment\Api\Data\IconInterface
     */
    public function setIconId($iconId)
    {
        return $this->setData(self::ICON_ID, $iconId);
    }

    /**
     * Get filetype
     * @return string|null
     */
    public function getFiletype()
    {
        return $this->_get(self::FILETYPE);
    }

    /**
     * Set filetype
     * @param string $filetype
     * @return \MagePrakash\ProductAttachment\Api\Data\IconInterface
     */
    public function setFiletype($filetype)
    {
        return $this->setData(self::FILETYPE, $filetype);
    }

    /**
     * Get image
     * @return string|null
     */
    public function getImage()
    {
        return $this->_get(self::IMAGE);
    }

    /**
     * Set image
     * @param string $image
     * @return \MagePrakash\ProductAttachment\Api\Data\IconInterface
     */
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }

    /**
     * Get is_active
     * @return string|null
     */
    public function getIsActive()
    {
        return $this->_get(self::IS_ACTIVE);
    }

    /**
     * Set is_active
     * @param string $isActive
     * @return \MagePrakash\ProductAttachment\Api\Data\IconInterface
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * Get icon_extension
     * @return string|null
     */
    public function getIconExtension()
    {
        return $this->_get(self::ICON_EXTENSION);
    }

    /**
     * Set icon_extension
     * @param string $iconExtension
     * @return \MagePrakash\ProductAttachment\Api\Data\IconInterface
     */
    public function setIconExtension($iconExtension)
    {
        return $this->setData(self::ICON_EXTENSION, $iconExtension);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \MagePrakash\ProductAttachment\Api\Data\IconExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \MagePrakash\ProductAttachment\Api\Data\IconExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \MagePrakash\ProductAttachment\Api\Data\IconExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
