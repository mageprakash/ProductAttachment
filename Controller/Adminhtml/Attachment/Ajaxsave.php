<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

declare(strict_types=1);
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace MagePrakash\ProductAttachment\Controller\Adminhtml\Attachment;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;

/**
 * Class for saving of customer address
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Ajaxsave extends Action implements HttpPostActionInterface
{
    

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var JsonFactory
     */
    private $resultJsonFactory;

    /**
     * @param Action\Context $context
     * @param \Magento\Customer\Api\AddressRepositoryInterface $addressRepository
     * @param \Magento\Customer\Model\Metadata\FormFactory $formFactory
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @param \Magento\Customer\Api\Data\AddressInterfaceFactory $addressDataFactory
     * @param LoggerInterface $logger
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
        Action\Context $context,
        \Magento\Customer\Api\AddressRepositoryInterface $addressRepository,
        \Magento\Customer\Model\Metadata\FormFactory $formFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \Magento\Customer\Api\Data\AddressInterfaceFactory $addressDataFactory,
        LoggerInterface $logger,
        JsonFactory $resultJsonFactory
    ) {
        parent::__construct($context);
        $this->addressRepository = $addressRepository;
        $this->formFactory = $formFactory;
        $this->customerRepository = $customerRepository;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->addressDataFactory = $addressDataFactory;
        $this->logger = $logger;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    /**
     * Save customer address action
     *
     * @return Json
     */
   /* public function execute(): Json
    {
        $customerId = $this->getRequest()->getParam('parent_id', false);
        $addressId = $this->getRequest()->getParam('entity_id', false);

        $error = false;
        try {
            
            $customer = $this->customerRepository->getById($customerId);

            $addressForm = $this->formFactory->create(
                'customer_address',
                'adminhtml_customer_address',
                [],
                false,
                false
            );
            $addressData = $addressForm->extractData($this->getRequest());
            $addressData = $addressForm->compactData($addressData);

            $addressData['region'] = [
                'region' => $addressData['region'] ?? null,
                'region_id' => $addressData['region_id'] ?? null,
            ];
            $addressToSave = $this->addressDataFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $addressToSave,
                $addressData,
                \Magento\Customer\Api\Data\AddressInterface::class
            );
            $addressToSave->setCustomerId($customer->getId());
            $addressToSave->setIsDefaultBilling(
                (bool)$this->getRequest()->getParam('default_billing', false)
            );
            $addressToSave->setIsDefaultShipping(
                (bool)$this->getRequest()->getParam('default_shipping', false)
            );
            if ($addressId) {
                $addressToSave->setId($addressId);
                $message = __('Customer address has been updated.');
            } else {
                $addressToSave->setId(null);
                $message = __('New customer address has been added.');
            }
            $savedAddress = $this->addressRepository->save($addressToSave);
            $addressId = $savedAddress->getId();
        } catch (NoSuchEntityException $e) {
            $this->logger->critical($e);
            $error = true;
            $message = __('There is no customer with such id.');
        } catch (LocalizedException $e) {
            $error = true;
            $message = __($e->getMessage());
            $this->logger->critical($e);
        } catch (\Exception $e) {
            $error = true;
            $message = __('We can\'t change customer address right now.');
            $this->logger->critical($e);
        }

        $addressId = empty($addressId) ? null : $addressId;
        $resultJson = $this->resultJsonFactory->create();
        $resultJson->setData(
            [
                'message' => $message,
                'error' => $error,
                'data' => [
                    'entity_id' => $addressId
                ]
            ]
        );

        return $resultJson;
    }*/

      public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        $error = false;
       
        if ($data) {
            $id = $this->getRequest()->getParam('attachment_id');
        
            $model = $this->_objectManager->create(\MagePrakash\ProductAttachment\Model\Attachment::class)->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Attachment no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
            
            if(isset($data['file'][0]['url'])){
                $data['size']           = $data['file'][0]['size'];
                $data['type']           = $data['file'][0]['type'];
                $data['filepath']       = $data['file'][0]['filepath'];
            }

            $data['attachment_scope']   = 1;
            $data['store_ids']          = isset($data['store_ids'])?implode(",", $data['store_ids']):'';
            $data['customer_groups']    = (isset($data['customer_groups']) && $data['customer_groups'])?implode(",", $data['customer_groups']):'0';
            
            /*$this->filterData($data);*/
            
            $model->setData($data);
           
            
            try {
                $model->save();
                
                $attachmentId = $model->getAttachmentId();
                $message = __('New customer address has been added.');
                
            } catch (NoSuchEntityException $e) {
                $this->logger->critical($e);
                $error = true;
                $message = __('There is no customer with such id.');
            } catch (LocalizedException $e) {
                $error = true;
                $message = __($e->getMessage());
                $this->logger->critical($e);
            } catch (\Exception $e) {
                $error = true;
                $message = __('We can\'t change customer address right now.');
                $this->logger->critical($e);
            }
        }

        $attachmentId = empty($attachmentId) ? null : $attachmentId;
        $resultJson = $this->resultJsonFactory->create();
        $resultJson->setData(
                [
                    'message' => $message,
                    'error' => $error,
                    'data' => [
                            'icon_image'        => $data['file'][0]['previewUrl'],
                            'attachment_id'     => $attachmentId,
                            'filename'          => $model->getFilename(),
                            'is_enable'         => $model->getIsEnable(),
                            'customer_groups'   => $model->getCustomerGroups(),
                            'filepath'          => $model->getFilepath(),
                            'store_ids'         => $model->getStoreIds()
                    ]
                ]
        );

        return $resultJson;
    }
}
