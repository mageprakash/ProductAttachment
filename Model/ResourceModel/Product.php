<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Model\ResourceModel;
use MagePrakash\ProductAttachment\Model\Directory;
use Magento\Framework\UrlInterface;

class Product extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    public $storeManager;

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
         $connectionName = null
    )
    {
        $this->storeManager = $storeManager;
        parent::__construct($context,$connectionName);
    }

    protected function _construct()
    {
        $this->_init('mageprakash_productattachment_product', 'product_attachment_id');
    }

    public function getProductIds($fileId)
    {
        $select = $this->getConnection()->select()
            ->from(['fsc' => $this->getMainTable()], ['product_id','attachment_id','product_attachment_id'])
            ->where('attachment_id = ?', (int)$fileId);
        
        if ($result = $this->getConnection()->fetchAssoc($select)) {
            return $result;
        }

        return [];
    }
    
    public function deleteAll($attachmentId)
    {
          $this->getConnection()->delete(
            $this->getMainTable(),
            [
                'attachment_id = ?' => (int)$attachmentId
            ]
        );
    }

    public function deleteAttachmentByProduct($attachmentId,$productId)
    {
        $this->getConnection()->delete(
            $this->getMainTable(),
            ['product_id = (?)' => $productId,'attachment_id = (?)' => $attachmentId]
        );
    }

    public function deleteByProductIds($productIds)
    {
        $this->getConnection()->delete(
            $this->getMainTable(),
            ['product_attachment_id IN (?)' => array_unique($productIds)]
        );
    }

    public function insertAttachmentProductData($productData)
    {
    	$this->getConnection()->insert($this->getMainTable(), $productData);
    }
}
