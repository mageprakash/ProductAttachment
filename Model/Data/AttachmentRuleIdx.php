<?php declare(strict_types=1);


namespace MagePrakash\ProductAttachment\Model\Data;

use MagePrakash\ProductAttachment\Api\Data\AttachmentRuleIdxInterface;


class AttachmentRuleIdx extends \Magento\Framework\Api\AbstractExtensibleObject implements AttachmentRuleIdxInterface
{

    /**
     * Get attachmentruleidx_id
     * @return string|null
     */
    public function getAttachmentruleidxId()
    {
        return $this->_get(self::ATTACHMENTRULEIDX_ID);
    }

    /**
     * Set attachmentruleidx_id
     * @param string $attachmentruleidxId
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentRuleIdxInterface
     */
    public function setAttachmentruleidxId($attachmentruleidxId)
    {
        return $this->setData(self::ATTACHMENTRULEIDX_ID, $attachmentruleidxId);
    }

    /**
     * Get rule_id
     * @return string|null
     */
    public function getRuleId()
    {
        return $this->_get(self::RULE_ID);
    }

    /**
     * Set rule_id
     * @param string $ruleId
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentRuleIdxInterface
     */
    public function setRuleId($ruleId)
    {
        return $this->setData(self::RULE_ID, $ruleId);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentRuleIdxExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \MagePrakash\ProductAttachment\Api\Data\AttachmentRuleIdxExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \MagePrakash\ProductAttachment\Api\Data\AttachmentRuleIdxExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}

