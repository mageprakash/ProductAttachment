<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Model\Attachment;

use Magento\Framework\App\Request\DataPersistorInterface;
use MagePrakash\ProductAttachment\Model\ResourceModel\Attachment\CollectionFactory;
use Magento\Framework\UrlInterface;
use MagePrakash\ProductAttachment\Model\Directory;
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $collection;

    protected $dataPersistor;

    protected $loadedData;
   
    private $formProductDetails;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $icon;    
    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        \MagePrakash\ProductAttachment\Model\Attachment\FormProductDetails $formProductDetails,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \MagePrakash\ProductAttachment\Model\ResourceModel\Icon $icon,
        array $meta = [],
        array $data = []
    ) {
        $this->storeManager = $storeManager;
        $this->formProductDetails = $formProductDetails;
        $this->collection = $collectionFactory->create();
        $this->icon = $icon;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        /*$iconsList = $this->icon->getListIconExtension();*/
       
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $data = $model->getData();
           
            if($data['attachment_scope'] == 1){
                $data['additional_scope'] = 'true';
                $data['conditions_scope'] = 'false'; 
            }elseif ($data['attachment_scope'] == 2) {
                $data['conditions_scope'] = 'true';
                $data['additional_scope'] = 'false';
            }elseif ($data['attachment_scope'] == 3) {
                $data['conditions_scope'] = 'true';
                $data['additional_scope'] = 'true';
            }
            
            if(isset($data['filepath']))
            {
                $imageUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA).Directory::MagePrakash_DIRECTORY_ATTACHMENT.$data['filepath'];

                $previewUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA).Directory::MagePrakash_DIRECTORY_ICON.$data['icon_image'];
                
                $data['file'][0]['name']        = $data['filename'];
                $data['file'][0]['filepath']    = $data['filepath'];
                $data['file'][0]['url']         = $imageUrl;
                $data['file'][0]['previewUrl']  = $previewUrl;
                $data['file'][0]['size']        = $data['size'];
                $data['file'][0]['type']        = $data['type'];
            }

            if($data['product_ids'] != "")
            {
                $data['product_ids'] = explode(",", $data['product_ids']);
                $this->formProductDetails->addProductDetails($data);
            }
            
            $this->loadedData[$model->getId()] = $data;
        }


        $data = $this->dataPersistor->get('mageprakash_productattachment_attachment');
        
        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('mageprakash_productattachment_attachment');
        }
        
        return $this->loadedData;
    }
}
