<?php declare(strict_types=1);


namespace MagePrakash\ProductAttachment\Model;

use MagePrakash\ProductAttachment\Api\Data\AttachmentRuleIdxInterface;
use MagePrakash\ProductAttachment\Api\Data\AttachmentRuleIdxInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;


class AttachmentRuleIdx extends \Magento\Framework\Model\AbstractModel
{

    protected $attachmentruleidxDataFactory;

    protected $dataObjectHelper;

    protected $_eventPrefix = 'mageprakash_productattachment_attachment_rule_idx';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param AttachmentRuleIdxInterfaceFactory $attachmentruleidxDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \MagePrakash\ProductAttachment\Model\ResourceModel\AttachmentRuleIdx $resource
     * @param \MagePrakash\ProductAttachment\Model\ResourceModel\AttachmentRuleIdx\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        AttachmentRuleIdxInterfaceFactory $attachmentruleidxDataFactory,
        DataObjectHelper $dataObjectHelper,
        \MagePrakash\ProductAttachment\Model\ResourceModel\AttachmentRuleIdx $resource,
        \MagePrakash\ProductAttachment\Model\ResourceModel\AttachmentRuleIdx\Collection $resourceCollection,
        array $data = []
    ) {
        $this->attachmentruleidxDataFactory = $attachmentruleidxDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve attachmentruleidx model with attachmentruleidx data
     * @return AttachmentRuleIdxInterface
     */
    public function getDataModel()
    {
        $attachmentruleidxData = $this->getData();
        
        $attachmentruleidxDataObject = $this->attachmentruleidxDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $attachmentruleidxDataObject,
            $attachmentruleidxData,
            AttachmentRuleIdxInterface::class
        );
        
        return $attachmentruleidxDataObject;
    }
}

