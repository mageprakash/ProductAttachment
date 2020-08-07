<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Block\Product;

use Magento\Customer\Model\Session;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;

class AttachmentsTab extends Template
{
  protected $_template = 'MagePrakash_ProductAttachment::attachments.phtml';

    /**
     * @var Registry
     */
    private $registry;

    /**
     * @var Session
     */
    private $customerSession;
    
    /**
    * @var Product
    */
    private $product;
    
    /**
    * @var ScopeConfig
    */    
    protected $_scopeConfig;

    protected $attachmentManagement;
    protected $attachmentRepository;
    public function __construct(
      Session $customerSession,
      Registry $registry,
      Template\Context $context,
      \MagePrakash\ProductAttachment\Model\ResourceModel\Product $product,
      \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
      \MagePrakash\ProductAttachment\Model\AttachmentManagement $attachmentManagement,
      \MagePrakash\ProductAttachment\Model\AttachmentRepository $attachmentRepository,
      array $data = []
    ) {
      parent::__construct($context, $data);
      $this->_scopeConfig = $scopeConfig;        
      $this->registry = $registry;
      $this->customerSession = $customerSession;
      $this->product = $product;
      $this->attachmentManagement = $attachmentManagement;
      $this->attachmentRepository = $attachmentRepository;
    }

    /**
     * @inheritdoc
     */
    public function toHtml()
    {
      $attachmentsEnabled = $this->_scopeConfig->getValue('attachments/general/enabled', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

      $productTabEnabled  = $this->_scopeConfig->getValue('attachments/product_tab/product_tab_enabled', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

      $productTabTile  = $this->_scopeConfig->getValue('attachments/product_tab/product_tab_label', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
      
      if (!$attachmentsEnabled || !$productTabEnabled) {
        return '';
      }

      $this->setTitle($productTabTile);
      return parent::toHtml();
    }

    /**
     * @return string
     */
    public function getWidgetType()
    {
      return 'tab';
    }

    public function getAttachments()
    {

      
     if ($product = $this->registry->registry('current_product')) {
    
       $data = $this->attachmentRepository->getAttachmentsByProductId($product->getId(),$this->customerSession->getCustomerGroupId(),$this->_storeManager->getStore()->getId());

        return $data;
      }
      return [];
    }

    public function convertToReadableSize($size){
        return $this->attachmentManagement->getConvertToReadableSize($size);
    }
  }
