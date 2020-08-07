<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Api\Data;

interface ProductInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const PRODUCT_ID = 'product_id';

    /**
     * Get product_id
     * @return string|null
     */
    public function getProductId();

    /**
     * Set product_id
     * @param string $productId
     * @return \MagePrakash\ProductAttachment\Api\Data\ProductInterface
     */
    public function setProductId($productId);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \MagePrakash\ProductAttachment\Api\Data\ProductExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \MagePrakash\ProductAttachment\Api\Data\ProductExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \MagePrakash\ProductAttachment\Api\Data\ProductExtensionInterface $extensionAttributes
    );
}
