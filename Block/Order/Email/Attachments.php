<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Block\Order\Email;

class Attachments extends \Magento\Framework\View\Element\Template
{
        /**
    * @var ConfigProvider
    */
    public $_scopeConfig;

        /**
     * @var int
     */
    protected $productId;

        /**
     * @var int
     */
    protected $customerGroupId;

    protected $attachmentManagement;    

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \MagePrakash\ProductAttachment\Model\AttachmentManagement $attachmentManagement,
        array $data = []
    ) {
        $this->attachmentManagement = $attachmentManagement;        
        $this->_scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }
    
    public function toHtml()
    {
        $attachmentsEnabled     = $this->_scopeConfig->getValue('attachments/general/enabled', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        $showAttachmentsEnabled = $this->_scopeConfig->getValue('attachments/order_email/show_attachments', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        if (!$attachmentsEnabled || !$showAttachmentsEnabled) {
            return '';
        }

        $this->productId        = $this->getParentBlock()->getItem()->getProductId();
        $this->storeId          = $this->getParentBlock()->getItem()->getOrder()->getStoreId();
        $this->customerGroupId  = $this->getParentBlock()->getItem()->getOrder()->getCustomerGroupId();
        
        return parent::toHtml();
    }

    public function getAttachmentTitle(){
        return $this->_scopeConfig->getValue('attachments/order_email/email_attachments_label', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getOrderProductsAttachments()
    {
        $data = $this->attachmentManagement->getMatchingAttachmentFrontend($this->productId,$this->customerGroupId,$this->storeId);
        return $data;
    }
    
    public function convertToReadableSize($size){
        return $this->attachmentManagement->getConvertToReadableSize($size);
    }
}
