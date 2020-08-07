<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Model;

use MagePrakash\ProductAttachment\Api\Data\AttachmentInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use MagePrakash\ProductAttachment\Api\Data\AttachmentInterface;
use MagePrakash\ProductAttachment\Model\Indexer\Rule\RuleProductIndexer;

class Attachment extends \Magento\Rule\Model\AbstractModel
{

    protected $dataObjectHelper;

    protected $attachmentDataFactory;

    const CACHE_TAG = 'mageprakash_productattachment';
    protected $_cacheTag = 'mageprakash_productattachment';
    protected $_eventPrefix = 'mageprakash_productattachment';

    protected $_productAttachmentFactory;

        /**
     * @var \Magento\CatalogRule\Model\Rule\Condition\CombineFactory
     */
    protected $_combineFactory;

    /**
     * Store matched product Ids
     *
     * @var array
     */
    protected $_productIds;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $_productCollectionFactory;


    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Store\Api\StoreRepositoryInterface $_storeRepository
     */
    protected $_storeRepository;

    /**
     * @var \Magento\Store\Api\StoreRepositoryInterface $_storeRepository
     */
    protected $AttachmentManagement;    
    
    /**
     * @var attachmentRuleIndexer
     */
    protected $attachmentRuleIndexer;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param AttachmentInterfaceFactory $attachmentDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \MagePrakash\ProductAttachment\Model\ResourceModel\Attachment $resource
     * @param \MagePrakash\ProductAttachment\Model\ResourceModel\Attachment\Collection $resourceCollection
     * @param array $data
     */

    public function __construct(
        \Magento\CatalogRule\Model\Rule\Condition\CombineFactory $combineFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Store\Api\StoreRepositoryInterface $storeRepository,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Framework\Model\ResourceModel\Iterator $resourceIterator,
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        AttachmentInterfaceFactory $attachmentDataFactory,
        DataObjectHelper $dataObjectHelper,
        \MagePrakash\ProductAttachment\Model\ResourceModel\Attachment $resource,
        \MagePrakash\ProductAttachment\Model\ResourceModel\Attachment\Collection $resourceCollection,
         \MagePrakash\ProductAttachment\Model\ProductFactory $productAttachmentFactory,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \MagePrakash\ProductAttachment\Model\AttachmentManagement $attachmentManagement,
        RuleProductIndexer $attachmentRuleIndexer,
        array $data = []
    ) {
        $this->_combineFactory = $combineFactory;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_productAttachmentFactory = $productAttachmentFactory;
        $this->_productFactory = $productFactory;
        $this->_storeManager = $storeManager;
        $this->_storeRepository = $storeRepository;
        $this->_resourceIterator = $resourceIterator;
        $this->attachmentDataFactory = $attachmentDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->attachmentManagement = $attachmentManagement;        
        $this->attachmentRuleIndexer = $attachmentRuleIndexer;
        parent::__construct($context, $registry,$formFactory, $localeDate, $resource, $resourceCollection, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('MagePrakash\ProductAttachment\Model\ResourceModel\Attachment');
    }


    /**
     * Retrieve attachment model with attachment data
     * @return AttachmentInterface
     */
    public function getDataModel()
    {     
        $attachmentData             = $this->getData();
        
        $productListByCoditionBase  = $this->attachmentManagement->getProductsByConditionBase($attachmentData['attachment_id'],0);
        $productListByProductBase  = $this->attachmentManagement->getProductsByProductBase($attachmentData['attachment_id'],0);        
        
       

        $productIdsByCoditionBase = array_column($productListByCoditionBase, 'product_id');
        $productIdsByProductBase  = array_column($productListByProductBase, 'product_id');
        $productIds               = array_unique (array_merge ($productIdsByCoditionBase, $productIdsByProductBase));
        $attachmentData['product_ids']  = implode(",", $productIds);

        $attachmentDataObject = $this->attachmentDataFactory->create();

        $this->dataObjectHelper->populateWithArray(
            $attachmentDataObject,
            $attachmentData,
            AttachmentInterface::class
        );
        
        return $attachmentDataObject;
    }

        /**
     * Update history after saving
     *
     * @return $this
     */
    public function afterSave()
    {
        parent::afterSave();
        $this->_productAttachmentFactory->create()->setAttachmentModel($this)->insertSave();
        $this->attachmentRuleIndexer->executeRow($this->getAttachmentId());
        return $this;
    }

   
    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId(), self::CACHE_TAG . '_' . $this->getIdentifier()];
    }

    /**
     * Getter for rule combine conditions instance
     *
     * @return \Magento\Rule\Model\Condition\Combine
     */
    public function getConditionsInstance()
    {
        return $this->_combineFactory->create();
    }

    /**
     * Getter for rule actions collection instance
     *
     * @return \Magento\Rule\Model\Action\Collection | null
     */
    public function getActionsInstance()
    {
        return null;
    }

    /**
     * Reset rule actions
     *
     * @param null|\Magento\Rule\Model\Action\Collection $actions
     * @return $this
     */
    protected function _resetActions($actions = null)
    {
        return $this;
    }

    /**
     * @param string $formName
     * @return string
     */
    public function getConditionsFieldSetId($formName = '')
    {
        return $formName . 'rule_conditions_fieldset_' . $this->getId();
    }

    /**
     * Get array of product ids which are matched by rule
     *
     * @return array
     */
    public function getMatchingProductIds()
    {
        if ($this->_productIds === null) {
            $this->_productIds = [];
            $this->setCollectedAttributes([]);

            /** @var $productCollection \Magento\Catalog\Model\ResourceModel\Product\Collection */
            $productCollection = $this->_productCollectionFactory->create();
            $productCollection->addWebsiteFilter($this->getWebsiteIds());

            $this->getConditions()->collectValidatedAttributes($productCollection);

            $this->_resourceIterator->walk(
                $productCollection->getSelect(),
                [[$this, 'callbackValidateProduct']],
                [
                    'attributes' => $this->getCollectedAttributes(),
                    'product' => $this->_productFactory->create()
                ]
            );
        }

        return $this->_productIds;
    }

    /**
     * Callback function for product matching
     *
     * @param array $args
     * @return void
     */
    public function callbackValidateProduct($args)
    {
        $product = clone $args['product'];
        $product->setData($args['row']);
        $websiteStores = $this->_getWebsitesStoresMap();
        $results = [];

        foreach ($websiteStores as $storeId) {
            $product->setStoreId($storeId);
            if ($this->getConditions()->validate($product)) {
                $results[$storeId] = $product->getId();
            }
        }
        if (!empty($results)) {
            $this->_productIds[] = $results;
        }
    }

    /**
     * Prepare website map
     *
     * @return array
     */
    protected function _getWebsitesMap()
    {
        $map = [];
        $websites = $this->_storeManager->getWebsites();
        foreach ($websites as $website) {
            // Continue if website has no store to be able to create catalog rule for website without store
            if ($website->getDefaultStore() === null) {
                continue;
            }
            $map[$website->getId()] = $website->getDefaultStore()->getId();
        }
        return $map;
    }

    /**
     * @return array
     */
    protected function _getStoreIdsMap()
    {
        $map = [];
        $stores = $this->_storeRepository->getList();
        foreach ($stores as $store) {
            if ($store->getId()) {
                $map[$store->getId()] = $store->getWebsiteId();
            }
        }
        return $map;
    }

    /**
     * @return mixed
     */
    protected function _getWebsitesStoresMap()
    {
        if (!$this->hasWebsitesStoresIds()) {
            $storesMap = $this->_getStoreIdsMap();
            $storeIds = explode(",", $this->getData('store_id'));
            if (in_array(0, $storeIds)) {
                $websiteStoreIds = array_keys($storesMap);
                $this->setData('websites_stores_ids', $websiteStoreIds);
            } else {
                $websiteStoreIds = [];
                foreach($storeIds as $id) {
                    $websiteStoreIds[] = $id;
                }
                $this->setData('websites_stores_ids', $websiteStoreIds);
            }
        }
        return $this->_getData('websites_stores_ids');
    }

    /**
     * @return array
     */
    public function getWebsiteIds()
    {
        if (!$this->hasWebsiteIds()) {
            $storesMap = $this->_getStoreIdsMap();
            $storeIds = explode(",", $this->getData('store_id'));
            if (in_array(0, $storeIds)) {
                $websiteIds = array_unique($storesMap);
                $this->setData('website_ids', $websiteIds);
            } else {
                $websiteIds = [];
                foreach($storeIds as $id) {
                    $websiteIds[] = $storesMap[$id];
                }
                $websiteIds = array_unique($websiteIds);
                $this->setData('website_ids', $websiteIds);
            }
        }
        return $this->_getData('website_ids');
    }

    /**
     * @return mixed
     */
    public function getAllStoreIdsAssigned()
    {
        return $this->_getWebsitesStoresMap();
    }
}
