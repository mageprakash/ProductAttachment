<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Controller\Adminhtml\Attachment;

use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{

    protected $dataPersistor;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
     
       

        if ($data) {
            $id = $this->getRequest()->getParam('attachment_id');
        
            $model = $this->_objectManager->create(\MagePrakash\ProductAttachment\Model\Attachment::class)->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Attachment no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            if(isset($data['file'][0]['url'])){
                $data['size']       = $data['file'][0]['size'];
                $data['type']       = $data['file'][0]['type'];
                $data['filepath']   = $data['file'][0]['filepath'];
            }
            
            $data['store_ids']       = isset($data['store_ids'])?implode(",", $data['store_ids']):'';
            $data['customer_groups'] = (isset($data['customer_groups']) && $data['customer_groups'])?implode(",", $data['customer_groups']):'0';
            
            /*$this->filterData($data);*/
            if (isset($data['rule'])) {
            $data['conditions'] = $data['rule']['conditions'];
                 unset($data['rule']);
            }

             if(isset($data['product_page_position']) && $data['product_page_position'] != 1) {
                $data['product_position'] = 10;
            }
           
            $model->setData($data);
            $model->loadPost($data);


            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Attachment.'));
                $this->dataPersistor->clear('mageprakash_productattachment_attachment');
        
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['attachment_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Attachment.'));
            }
        
            $this->dataPersistor->set('mageprakash_productattachment_attachment', $data);
            return $resultRedirect->setPath('*/*/edit', ['attachment_id' => $this->getRequest()->getParam('attachment_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

/*    private function filterData(&$data)
    {
        if (!empty($data['fileproducts']['products'])) {
            $productIds = [];
            foreach ($data['fileproducts']['products'] as $product) {
                $productIds[] = (int)$product['entity_id'];
            }
            $data['product_ids'] = array_unique($productIds);
        } else {
            $data["product_ids"] = [];
        }
    }*/
}
