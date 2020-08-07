<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Model;

use MagePrakash\ProductAttachment\Api\Data\ProductInterface;
use MagePrakash\ProductAttachment\Api\Data\ProductInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;

class Product extends \Magento\Framework\Model\AbstractModel
{

    protected $productDataFactory;

    protected $dataObjectHelper;

    protected $_eventPrefix = 'mageprakash_productattachment_product';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param ProductInterfaceFactory $productDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \MagePrakash\ProductAttachment\Model\ResourceModel\Product $resource
     * @param \MagePrakash\ProductAttachment\Model\ResourceModel\Product\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        ProductInterfaceFactory $productDataFactory,
        DataObjectHelper $dataObjectHelper,
        \MagePrakash\ProductAttachment\Model\ResourceModel\Product $resource,
        \MagePrakash\ProductAttachment\Model\ResourceModel\Product\Collection $resourceCollection,
        array $data = []
    ) {
        $this->productDataFactory = $productDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Initialize resource
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\MagePrakash\ProductAttachment\Model\ResourceModel\Product::class);
    }
    /**
     * Retrieve product model with product data
     * @return ProductInterface
     */
    public function getDataModel()
    {
        $productData = $this->getData();
        
        $productDataObject = $this->productDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $productDataObject,
            $productData,
            ProductInterface::class
        );
        
        return $productDataObject;
    }
     private function filterData(&$data)
    {
        if (!empty($data['fileproducts']['products'])) {
            $productIds = [];
            foreach ($data['fileproducts']['products'] as $product) {
                $productIds[] = (int)$product['entity_id'];
            }
            $data['product_ids'] = array_unique($productIds);
        } else {
            $data["product_ids"] = [];
        }
    }
    
    public function productAttachementSave($params)
    {
        $toDelete = [];
        if (!empty($params['delete'])) {
            $toDelete = $params['delete'];
        }
        
        if ($attachments = $params['attachments']) {
            foreach ($attachments as $attachment) {
                if (!empty($attachment['product_attachment_id'])) {
                        unset($toDelete[$attachment['attachment_id']]);
                }else{
                    $productData = ['attachment_id' => $attachment['attachment_id'],'product_id' => $params['product']];
                    $this->_resource->insertAttachmentProductData($productData);
                }
            }
        }

        if (!empty($toDelete)){
            foreach (array_keys($toDelete) as $attachmentId) {
                $this->_resource->deleteAttachmentByProduct($attachmentId,$params['product']);
            }
        }
    }

    public function insertSave()
    {

        $balance = $this->getAttachmentModel();
        if (!$balance || !$balance->getAttachmentId()) {
            throw new LocalizedException(__('A balance is needed to save a balance history.'));
        }
        $dataff = $_POST;
        $this->filterData($dataff);

        if(!empty($dataff['product_ids']))
        {
           
            $currentProducts = $this->_resource->getProductIds($balance->getAttachmentId());

            foreach ($dataff['product_ids'] as $productId) {
                if (array_key_exists($productId, $currentProducts)) {
                    unset($currentProducts[$productId]);
                }else{
                    if($productId != "" && $balance->getAttachmentId())
                    {
                        $productData = ['attachment_id' => $balance->getAttachmentId(),'product_id' => $productId];
                        $this->_resource->insertAttachmentProductData($productData);
                    }
                }
            }
            if (!empty($currentProducts)) {
                $productsToDelete = [];
                foreach ($currentProducts as $productStore) {
                    $productsToDelete[] = $productStore['product_attachment_id'];
                }
                $this->_resource->deleteByProductIds($productsToDelete);
            }

        }else{
            $this->_resource->deleteAll($balance->getAttachmentId());
        }
        return parent::beforeSave();
    }

}