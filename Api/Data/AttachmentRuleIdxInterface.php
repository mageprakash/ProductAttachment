<?php declare(strict_types=1);


namespace MagePrakash\ProductAttachment\Api\Data;


interface AttachmentRuleIdxInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const RULE_ID = 'rule_id';
    const ATTACHMENTRULEIDX_ID = 'attachmentruleidx_id';

    /**
     * Get attachmentruleidx_id
     * @return string|null
     */
    public function getAttachmentruleidxId();

    /**
     * Set attachmentruleidx_id
     * @param string $attachmentruleidxId
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentRuleIdxInterface
     */
    public function setAttachmentruleidxId($attachmentruleidxId);

    /**
     * Get rule_id
     * @return string|null
     */
    public function getRuleId();

    /**
     * Set rule_id
     * @param string $ruleId
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentRuleIdxInterface
     */
    public function setRuleId($ruleId);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \MagePrakash\ProductAttachment\Api\Data\AttachmentRuleIdxExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \MagePrakash\ProductAttachment\Api\Data\AttachmentRuleIdxExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \MagePrakash\ProductAttachment\Api\Data\AttachmentRuleIdxExtensionInterface $extensionAttributes
    );
}

