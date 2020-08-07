<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Block\Account\Order;

class Attachments extends \Magento\Framework\View\Element\Template
{
   // protected $_template = 'account/order/attachments.phtml';

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
    protected $order;

    protected $attachmentManagement;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \MagePrakash\ProductAttachment\Model\AttachmentManagement $attachmentManagement,        
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_scopeConfig = $scopeConfig;
        $this->attachmentManagement = $attachmentManagement;        
    }

    public function toHtml()
    {
        $this->productId = $this->getParentBlock()->getItem()->getProductId();
        $this->order   = $this->getParentBlock()->getItem()->getOrder();

        $attachmentsEnabled     = $this->_scopeConfig->getValue('attachments/general/enabled', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        $orderViewTabEnabled      = $this->_scopeConfig->getValue('attachments/order_view/order_view_attachments_show', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        $orderViewTabLabel  = $this->_scopeConfig->getValue('attachments/order_view/order_view_attachments_label', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        if (!$attachmentsEnabled || !$orderViewTabEnabled) {
            return '';
        }
        
        return parent::toHtml();
    }
    
    public function getOrderProductsAttachments()
    {
        $data = $this->attachmentManagement->getMatchingAttachmentFrontend($this->productId,$this->order->getCustomerGroupId(),$this->order->getStoreId());
        
        return $data;
    }
    
    public function convertToReadableSize($size){
        return $this->attachmentManagement->getConvertToReadableSize($size);
    }
}