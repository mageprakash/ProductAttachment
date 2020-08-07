<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */


namespace MagePrakash\ProductAttachment\Controller\Adminhtml\Icon;

use Magento\Framework\Controller\ResultFactory;

/**
 * Class Upload
 */
class Upload extends \Magento\Backend\App\Action
{
    /**
     * @var \MagePrakash\ProductAttachment\Model\Filesystem\FileUploader
     */
    private $fileUploader;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \MagePrakash\ProductAttachment\Model\FileUploader $fileUploader
    ) {
        parent::__construct($context);
        $this->fileUploader = $fileUploader;
    }

    /**
     * Upload file controller action.
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        return $resultJson->setData($this->fileUploader->uploadFile('image','icon'));
    }
}
