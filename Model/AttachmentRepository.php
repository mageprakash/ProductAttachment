<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Model;

use MagePrakash\ProductAttachment\Api\Data\AttachmentInterfaceFactory;
use MagePrakash\ProductAttachment\Api\Data\AttachmentSearchResultsInterfaceFactory;
use MagePrakash\ProductAttachment\Model\ResourceModel\Attachment\CollectionFactory as AttachmentCollectionFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use MagePrakash\ProductAttachment\Api\AttachmentRepositoryInterface;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Exception\NoSuchEntityException;
use MagePrakash\ProductAttachment\Model\ResourceModel\Attachment as ResourceAttachment;

class AttachmentRepository implements AttachmentRepositoryInterface
{

    protected $dataObjectHelper;

    private $storeManager;

    protected $searchResultsFactory;

    protected $dataObjectProcessor;

    protected $dataAttachmentFactory;

    protected $extensionAttributesJoinProcessor;

    private $collectionProcessor;

    protected $resource;

    protected $attachmentFactory;

    protected $extensibleDataObjectConverter;
    protected $attachmentCollectionFactory;
    protected $attachmentManagement;

    /**
     * @param ResourceAttachment $resource
     * @param AttachmentFactory $attachmentFactory
     * @param AttachmentInterfaceFactory $dataAttachmentFactory
     * @param AttachmentCollectionFactory $attachmentCollectionFactory
     * @param AttachmentSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceAttachment $resource,
        AttachmentFactory $attachmentFactory,
        AttachmentInterfaceFactory $dataAttachmentFactory,
        AttachmentCollectionFactory $attachmentCollectionFactory,
        AttachmentSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter,
        AttachmentManagement $attachmentManagement
    ) {
        $this->attachmentManagement = $attachmentManagement;
        $this->resource = $resource;
        $this->attachmentFactory = $attachmentFactory;
        $this->attachmentCollectionFactory = $attachmentCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataAttachmentFactory = $dataAttachmentFactory;
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
        \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface $attachment
    ) {
     
        /* if (empty($attachment->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $attachment->setStoreId($storeId);
        } */
       

        $attachmentData = $this->extensibleDataObjectConverter->toNestedArray(
            $attachment,
            [],
            \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface::class
        );

        $attachmentModel = $this->attachmentFactory->create()->setData($attachmentData);
        
        try {
            $this->resource->save($attachmentModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the attachment: %1',
                $exception->getMessage()
            ));
        }
        return $attachmentModel->getDataModel();
    }

    public function getAttachmentsByProductId($productId,$customerGroupId,$storeId){
       $data = $this->attachmentManagement->getMatchingAttachmentFrontend($productId,$customerGroupId,$storeId);
      return  $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($attachmentId)
    {
        $attachment = $this->attachmentFactory->create();
        $this->resource->load($attachment, $attachmentId);
        if (!$attachment->getId()) {
            throw new NoSuchEntityException(__('attachment with id "%1" does not exist.', $attachmentId));
        }
        return $attachment->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
       
        $collection = $this->attachmentCollectionFactory->create();
        
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface::class
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
        \MagePrakash\ProductAttachment\Api\Data\AttachmentInterface $attachment
    ) {
        try {
            $attachmentModel = $this->attachmentFactory->create();
            $this->resource->load($attachmentModel, $attachment->getAttachmentId());
            $this->resource->delete($attachmentModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the attachment: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($attachmentId)
    {
        return $this->delete($this->getById($attachmentId));
    }
}
