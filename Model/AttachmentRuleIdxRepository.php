<?php declare(strict_types=1);


namespace MagePrakash\ProductAttachment\Model;

use MagePrakash\ProductAttachment\Api\AttachmentRuleIdxRepositoryInterface;
use MagePrakash\ProductAttachment\Api\Data\AttachmentRuleIdxInterfaceFactory;
use MagePrakash\ProductAttachment\Api\Data\AttachmentRuleIdxSearchResultsInterfaceFactory;
use MagePrakash\ProductAttachment\Model\ResourceModel\AttachmentRuleIdx as ResourceAttachmentRuleIdx;
use MagePrakash\ProductAttachment\Model\ResourceModel\AttachmentRuleIdx\CollectionFactory as AttachmentRuleIdxCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;


class AttachmentRuleIdxRepository implements AttachmentRuleIdxRepositoryInterface
{

    protected $resource;

    protected $attachmentRuleIdxFactory;

    protected $attachmentRuleIdxCollectionFactory;

    protected $searchResultsFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $dataAttachmentRuleIdxFactory;

    protected $extensionAttributesJoinProcessor;

    private $storeManager;

    private $collectionProcessor;

    protected $extensibleDataObjectConverter;

    /**
     * @param ResourceAttachmentRuleIdx $resource
     * @param AttachmentRuleIdxFactory $attachmentRuleIdxFactory
     * @param AttachmentRuleIdxInterfaceFactory $dataAttachmentRuleIdxFactory
     * @param AttachmentRuleIdxCollectionFactory $attachmentRuleIdxCollectionFactory
     * @param AttachmentRuleIdxSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceAttachmentRuleIdx $resource,
        AttachmentRuleIdxFactory $attachmentRuleIdxFactory,
        AttachmentRuleIdxInterfaceFactory $dataAttachmentRuleIdxFactory,
        AttachmentRuleIdxCollectionFactory $attachmentRuleIdxCollectionFactory,
        AttachmentRuleIdxSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->attachmentRuleIdxFactory = $attachmentRuleIdxFactory;
        $this->attachmentRuleIdxCollectionFactory = $attachmentRuleIdxCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataAttachmentRuleIdxFactory = $dataAttachmentRuleIdxFactory;
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
        \MagePrakash\ProductAttachment\Api\Data\AttachmentRuleIdxInterface $attachmentRuleIdx
    ) {
        /* if (empty($attachmentRuleIdx->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $attachmentRuleIdx->setStoreId($storeId);
        } */
        
        $attachmentRuleIdxData = $this->extensibleDataObjectConverter->toNestedArray(
            $attachmentRuleIdx,
            [],
            \MagePrakash\ProductAttachment\Api\Data\AttachmentRuleIdxInterface::class
        );
        
        $attachmentRuleIdxModel = $this->attachmentRuleIdxFactory->create()->setData($attachmentRuleIdxData);
        
        try {
            $this->resource->save($attachmentRuleIdxModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the attachmentRuleIdx: %1',
                $exception->getMessage()
            ));
        }
        return $attachmentRuleIdxModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($attachmentRuleIdxId)
    {
        $attachmentRuleIdx = $this->attachmentRuleIdxFactory->create();
        $this->resource->load($attachmentRuleIdx, $attachmentRuleIdxId);
        if (!$attachmentRuleIdx->getId()) {
            throw new NoSuchEntityException(__('attachmentRuleIdx with id "%1" does not exist.', $attachmentRuleIdxId));
        }
        return $attachmentRuleIdx->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->attachmentRuleIdxCollectionFactory->create();
        
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \MagePrakash\ProductAttachment\Api\Data\AttachmentRuleIdxInterface::class
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
        \MagePrakash\ProductAttachment\Api\Data\AttachmentRuleIdxInterface $attachmentRuleIdx
    ) {
        try {
            $attachmentRuleIdxModel = $this->attachmentRuleIdxFactory->create();
            $this->resource->load($attachmentRuleIdxModel, $attachmentRuleIdx->getAttachmentruleidxId());
            $this->resource->delete($attachmentRuleIdxModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the attachmentRuleIdx: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($attachmentRuleIdxId)
    {
        return $this->delete($this->get($attachmentRuleIdxId));
    }
}

