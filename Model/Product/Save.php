<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Model\Product;
class Save implements \Magento\Framework\Event\ObserverInterface
{
    private $product;

    public function __construct(
        \MagePrakash\ProductAttachment\Model\Product $product
    ) {
        $this->product = $product;
    }

    /**
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {

        $productbase = $observer->getController()->getRequest()->getParam('productbase');
       
        $params = [
            'attachments' => !empty($productbase['productattachments']) ? $productbase['productattachments'] : false,
            'product' => $observer->getProduct()->getId(),
            'store' => (int)$observer->getController()->getRequest()->getParam('store')
        ];
        if (!empty($productbase['delete'])) {
            $params['delete'] = $productbase['delete'];
        }
        
        $this->product->productAttachementSave($params);
       
    }
}