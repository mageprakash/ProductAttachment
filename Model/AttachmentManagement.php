<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Model;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use MagePrakash\ProductAttachment\Model\Attachment;

use MagePrakash\ProductAttachment\Model\AttachmentFactory;
use MagePrakash\ProductAttachment\Model\IconFactory;
use MagePrakash\ProductAttachment\Model\AttachmentRuleIdxFactory;
use MagePrakash\ProductAttachment\Model\ProductFactory;

use MagePrakash\ProductAttachment\Model\ResourceModel\Attachment\CollectionFactory as AttachmentCollectionFactory;
use Magento\Catalog\Model\Product;
use Magento\Framework\UrlInterface;
use MagePrakash\ProductAttachment\Model\Directory;

class AttachmentManagement
{
    /**
     * @var int
     */
    protected $batchCount;

    /**
     * @var string
     */
    protected $indexTableName;

    /**
     * @var AdapterInterface
     */
    protected $connection;

    /**
     * @var ResourceConnection
     */
    protected $resource;

    /**
     * @var AttachmentCollectionFactory
     */
    protected $AttachmentCollectionFactory;

    /**
     * @var attachmentFactory
     */
    protected $attachmentFactory;

        /**
     * @var iconFactory
     */
    protected $iconFactory;

        /**
     * @var attachmentRuleIdxFactory
     */
    protected $attachmentRuleIdxFactory;

        /**
     * @var productFactory
     */
    protected $productFactory;

        /**
     * @var attachmentItemsInterfaceFactory
     */
    protected $attachmentItemsInterfaceFactory;
    /**
     * @var ProductLoader
     */
    private $productLoader;
    
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $icon;

    public $storeManager;

    /**
     * @param ResourceConnection $resource
     * @param AttachmentCollectionFactory $AttachmentCollectionFactory
     * @param AttachmentFactory $Attachmentactory
     * @param ProductLoader $productLoader
     */
    public function __construct(
        ResourceConnection $resource,
        AttachmentCollectionFactory $AttachmentCollectionFactory,
        AttachmentFactory $attachmentFactory,
        IconFactory $iconFactory,
        AttachmentRuleIdxFactory $attachmentRuleIdxFactory,
        ProductFactory $productFactory,
        \MagePrakash\ProductAttachment\Model\ResourceModel\Icon $icon,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \MagePrakash\ProductAttachment\Api\Data\AttachmentItemsInterfaceFactory $attachmentItemsInterfaceFactory
    )
    {
        $this->storeManager = $storeManager;
        $this->icon = $icon;
        $this->resource = $resource;
        $this->connection = $resource->getConnection();
        $this->AttachmentCollectionFactory = $AttachmentCollectionFactory;
        $this->attachmentItemsInterfaceFactory = $attachmentItemsInterfaceFactory;
        $this->attachmentFactory = $attachmentFactory;
        $this->iconFactory = $iconFactory;
        $this->attachmentRuleIdxFactory = $attachmentRuleIdxFactory;
        $this->productFactory = $productFactory;

        $this->indexTableName = 'mageprakash_productattachment_attachment_rule_idx';
    }

    public function getConvertToReadableSize($size){
        
        $size = floatval($size);
        $base = log($size) / log(1024);
        $suffix = array("", "KB", "MB", "GB", "TB");
        $f_base = floor($base);
        return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
    }
    
    public function getMatchingAttachmentFrontend($productIds,$customerGroupId,$storeId)
    {

        $attachmentItems = $this->attachmentItemsInterfaceFactory->create();

        $mpari = $this->resource->getTableName('mageprakash_productattachment_attachment_rule_idx');
        $mpa = $this->resource->getTableName('mageprakash_productattachment_attachment');
        $mpi = $this->resource->getTableName('mageprakash_productattachment_icon');
        $mpp = $this->resource->getTableName('mageprakash_productattachment_product');
        
        $attachmentCollection = $this->attachmentFactory->create()->getCollection();
        $attachmentCollection->getSelect()
        ->joinLeft(
            ['mageprakash_attachment_icon' => $mpi],'mageprakash_attachment_icon.icon_id = main_table.icon_id',["icon_image" => 'mageprakash_attachment_icon.image']
        )->joinLeft(
            ['mpari' => $mpari],'mpari.rule_id = main_table.attachment_id',
            [
                "rule_id" => "mpari.rule_id"
            ]
        )->joinLeft(
            ['mpp' => $mpp],'mpp.attachment_id = main_table.attachment_id',
            [
                "product_attachment_id" => "mpp.product_attachment_id"
            ]
        );

        $attachmentCollection->addFieldToFilter(
            array(
                'mpari.product_id',
                'mpp.product_id'
                ),
            array(
                array('in' => $productIds),
                array('in' => $productIds)
            )
        );

        $attachmentCollection->addFieldToFilter('main_table.store_ids', 
            array(
                array('finset' => $storeId),
                array('finset' => 0)
            )
        );
        
        $items = [];
       
        foreach ($attachmentCollection as $item)
        {
            
            $iconImage = ($item->getIconImage())?$this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA)
                .Directory::MagePrakash_DIRECTORY_ICON. $item->getIconImage():'';
            $item->setIconImage($iconImage);
            $items[] = $item;
        }
        $attachmentItems->setItems($items);
        return $attachmentItems;
    }

    public function getMatchingAttachmentByProductBase($productId, $storeId)
    {
        $mpa = $this->resource->getTableName('mageprakash_productattachment_attachment');
        $mpi = $this->resource->getTableName('mageprakash_productattachment_icon');
        $mpp = $this->resource->getTableName('mageprakash_productattachment_product');

        $select = $this->connection->select()
            ->from(['fsp' => $mpp],['*'])
            ->joinLeft(
                ['attachment' => $mpa],
                'attachment.attachment_id = fsp.attachment_id',['*']
            )
            ->joinLeft(
                ['mageprakash_icon'    => $mpi],
                'mageprakash_icon.icon_id = attachment.icon_id',
                [
                    "icon_image" => 'mageprakash_icon.image'
                ]
            )
            ->where('fsp.product_id = ?', (int)$productId)
            ->where('attachment.store_ids IN (?)', [0, $storeId])
            ->group('fsp.attachment_id');

        if ($result = $this->connection->fetchAll($select)) {
            foreach ($result as &$value) {
                $value['icon_image'] =  $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA).Directory::MagePrakash_DIRECTORY_ICON. $value['icon_image'];
            }
            return $result;
        }

        return [];
    }

    public function getMatchingAttachmentByConditionBase($productId, $storeId)
    {
        $mpari = $this->resource->getTableName('mageprakash_productattachment_attachment_rule_idx');
        $mpa = $this->resource->getTableName('mageprakash_productattachment_attachment');
        $mpi = $this->resource->getTableName('mageprakash_productattachment_icon');

        $select = $this->connection->select()->from(['fsp' => $mpari],['*'])
        ->joinLeft(
            ['attachment' => $mpa],
            'attachment.attachment_id = fsp.rule_id',['*']
        )
        ->joinLeft(
            ['mageprakash_icon'    => $mpi],
            'mageprakash_icon.icon_id = attachment.icon_id',
            [
                "icon_image" => 'mageprakash_icon.image'
            ]
        )
        ->where('fsp.product_id = ?', (int)$productId)
        ->where('attachment.store_ids IN (?)', [0, $storeId])
        ->group('fsp.rule_id');

        if ($result = $this->connection->fetchAll($select)) {
            foreach ($result as &$value) {
                $value['icon_image'] =  $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA).Directory::MagePrakash_DIRECTORY_ICON. $value['icon_image'];
            }
            return $result;
        }

        return [];
    }

    public function getProductsByConditionBase($attachmentId, $storeId){
        $mpari = $this->resource->getTableName('mageprakash_productattachment_attachment_rule_idx');
        $mpa = $this->resource->getTableName('mageprakash_productattachment_attachment');
        $mpi = $this->resource->getTableName('mageprakash_productattachment_icon');

        $select = $this->connection->select()->from(['mpari' => $mpari],['*'])
        ->joinLeft(
            ['attachment' => $mpa],
            'attachment.attachment_id = mpari.rule_id',['*']
        )
        ->joinLeft(
            ['mageprakash_icon'    => $mpi],
            'mageprakash_icon.icon_id = attachment.icon_id',
            [
                "icon_image" => 'mageprakash_icon.image'
            ]
        )
        ->where('mpari.rule_id = ?', (int)$attachmentId)
        ->where('attachment.store_ids IN (?)', [0, $storeId])
        ->group('mpari.product_id');
      
        if ($result = $this->connection->fetchAll($select)) {
            foreach ($result as &$value) {
                $value['icon_image'] =  $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA).Directory::MagePrakash_DIRECTORY_ICON. $value['icon_image'];
            }
            return $result;
        }

        return [];
    }

    public function getProductsByProductBase($attachmentId, $storeId){
        $mpa = $this->resource->getTableName('mageprakash_productattachment_attachment');
        $mpi = $this->resource->getTableName('mageprakash_productattachment_icon');
        $mpp = $this->resource->getTableName('mageprakash_productattachment_product');

        $select = $this->connection->select()
            ->from(['mpp' => $mpp],['*'])
            ->joinLeft(
                ['attachment' => $mpa],
                'attachment.attachment_id = mpp.attachment_id',['*']
            )
            ->joinLeft(
                ['mageprakash_icon'    => $mpi],
                'mageprakash_icon.icon_id = attachment.icon_id',
                [
                    "icon_image" => 'mageprakash_icon.image'
                ]
            )
            ->where('mpp.attachment_id = ?', (int)$attachmentId)
            ->where('attachment.store_ids IN (?)', [0, $storeId])
            ->group('mpp.product_id');

        if ($result = $this->connection->fetchAll($select)) {
            foreach ($result as &$value) {
                $value['icon_image'] =  $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA).Directory::MagePrakash_DIRECTORY_ICON. $value['icon_image'];
            }
            return $result;
        }

        return [];
    }    
}
