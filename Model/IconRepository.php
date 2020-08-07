<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Api\DataObjectHelper;
use MagePrakash\ProductAttachment\Model\ResourceModel\Icon\CollectionFactory as IconCollectionFactory;
use MagePrakash\ProductAttachment\Api\Data\IconSearchResultsInterfaceFactory;
use MagePrakash\ProductAttachment\Api\Data\IconInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use MagePrakash\ProductAttachment\Model\ResourceModel\Icon as ResourceIcon;
use Magento\Framework\Reflection\DataObjectProcessor;
use MagePrakash\ProductAttachment\Api\IconRepositoryInterface;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;

class IconRepository implements IconRepositoryInterface
{

    protected $searchResultsFactory;

    protected $dataObjectHelper;

    protected $iconCollectionFactory;

    protected $dataObjectProcessor;

    protected $iconFactory;

    protected $extensionAttributesJoinProcessor;

    protected $dataIconFactory;

    private $collectionProcessor;

    protected $resource;

    private $storeManager;

    protected $extensibleDataObjectConverter;

    /**
     * @param ResourceIcon $resource
     * @param IconFactory $iconFactory
     * @param IconInterfaceFactory $dataIconFactory
     * @param IconCollectionFactory $iconCollectionFactory
     * @param IconSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceIcon $resource,
        IconFactory $iconFactory,
        IconInterfaceFactory $dataIconFactory,
        IconCollectionFactory $iconCollectionFactory,
        IconSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->iconFactory = $iconFactory;
        $this->iconCollectionFactory = $iconCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataIconFactory = $dataIconFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \MagePrakash\ProductAttachment\Api\Data\IconInterface $icon
    ) {
        /* if (empty($icon->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $icon->setStoreId($storeId);
        } */
        
        $iconData = $this->extensibleDataObjectConverter->toNestedArray(
            $icon,
            [],
            \MagePrakash\ProductAttachment\Api\Data\IconInterface::class
        );
        
        $iconModel = $this->iconFactory->create()->setData($iconData);
        
        try {
            $this->resource->save($iconModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the icon: %1',
                $exception->getMessage()
            ));
        }
        return $iconModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getById($iconId)
    {
        $icon = $this->iconFactory->create();
        $this->resource->load($icon, $iconId);
        if (!$icon->getId()) {
            throw new NoSuchEntityException(__('icon with id "%1" does not exist.', $iconId));
        }
        return $icon->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->iconCollectionFactory->create();
        
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \MagePrakash\ProductAttachment\Api\Data\IconInterface::class
        );
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \MagePrakash\ProductAttachment\Api\Data\IconInterface $icon
    ) {
        try {
            $iconModel = $this->iconFactory->create();
            $this->resource->load($iconModel, $icon->getIconId());
            $this->resource->delete($iconModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the icon: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($iconId)
    {
        return $this->delete($this->getById($iconId));
    }
}
