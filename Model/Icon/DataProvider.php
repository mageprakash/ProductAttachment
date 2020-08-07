<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Model\Icon;

use MagePrakash\ProductAttachment\Model\ResourceModel\Icon\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\UrlInterface;
use MagePrakash\ProductAttachment\Model\Directory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $dataPersistor;

    protected $loadedData;
    protected $collection;


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
        \Magento\Store\Model\StoreManagerInterface $storeManager,        
        array $meta = [],
        array $data = []
    ) {
        $this->storeManager = $storeManager;
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
        /**
     * Get data
     *
     * @return array
     */

        /**
     * @param $path
     * @param $fileName
     *
     * @return string
     */
    public function getFilePath($path, $fileName)
    {
        return rtrim($path, '/') . '/' . ltrim($fileName, '/');
    }
    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {

            $data = $model->getData();

            if(isset($data['image']))
            {
                $imageName = $data['image'];

                $imageUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA).Directory::MagePrakash_DIRECTORY_ICON. $data['image'];
                
                unset($data['image']);
                $data['image'][0]['name']           = $imageName;                
                $data['image'][0]['url']            = $imageUrl;
                $data['image'][0]['previewUrl']     = $imageUrl;
                $data['image'][0]['previewType']    = "image";
            }
             $data['previewType']  = "image";
            $this->loadedData[$model->getId()] = $data;
        }
        $data = $this->dataPersistor->get('mageprakash_productattachment_icon');
        
        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('mageprakash_productattachment_icon');
        }
        
        return $this->loadedData;
    }
}
