<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Model;

use Magento\Framework\Api\DataObjectHelper;
use MagePrakash\ProductAttachment\Api\Data\IconInterfaceFactory;
use MagePrakash\ProductAttachment\Api\Data\IconInterface;

class Icon extends \Magento\Framework\Model\AbstractModel
{

    protected $iconDataFactory;

    protected $dataObjectHelper;

    protected $_eventPrefix = 'mageprakash_productattachment_icon';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param IconInterfaceFactory $iconDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \MagePrakash\ProductAttachment\Model\ResourceModel\Icon $resource
     * @param \MagePrakash\ProductAttachment\Model\ResourceModel\Icon\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        IconInterfaceFactory $iconDataFactory,
        DataObjectHelper $dataObjectHelper,
        \MagePrakash\ProductAttachment\Model\ResourceModel\Icon $resource,
        \MagePrakash\ProductAttachment\Model\ResourceModel\Icon\Collection $resourceCollection,
        array $data = []
    ) {
        $this->iconDataFactory = $iconDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve icon model with icon data
     * @return IconInterface
     */
    public function getDataModel()
    {
        $iconData = $this->getData();
        
        $iconDataObject = $this->iconDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $iconDataObject,
            $iconData,
            IconInterface::class
        );
        
        return $iconDataObject;
    }
}
