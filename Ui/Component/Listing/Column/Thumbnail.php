<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\UrlInterface;
use MagePrakash\ProductAttachment\Model\Directory;

class Thumbnail extends \Magento\Ui\Component\Listing\Columns\Column
{
    const NAME = 'thumbnail';

    const ALT_FIELD = 'name';


    private $_getModel;
    /**
     * @var string
     */
    private $editUrl;

    private $_objectManager = null;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param \Webkul\Hello\Model\Image\Image $imageHelper
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,        
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->urlBuilder = $urlBuilder;
        $this->storeManager = $storeManager;
        $this->_objectManager = $objectManager;
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = 'icon_image';
            foreach ($dataSource['data']['items'] as & $item) {
                
                $filename = $item['icon_image'];
                $previewUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA).Directory::MagePrakash_DIRECTORY_ICON.$filename;
                
                $item[$fieldName . '_src']      = $previewUrl;
                $item[$fieldName . '_alt']      = $this->getAlt($item) ?: $filename;
                $item[$fieldName . '_orig_src'] = $previewUrl;
            }
        }
        
        return $dataSource;
    }
   /**
   * @param array $row
   *
   * @return null|string
   */
     protected function getAlt($row)
     {
       $altField = $this->getData('config/altField') ?: self::ALT_FIELD;
       return isset($row[$altField]) ? $row[$altField] : null;
     }
}