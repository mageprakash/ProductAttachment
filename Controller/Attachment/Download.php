<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Controller\Attachment;
use MagePrakash\ProductAttachment\Model\Directory;
use Magento\Customer\Model\Session;
use Magento\Downloadable\Helper\Download as DownloadHelper;
use Magento\Framework\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Store\Model\StoreManagerInterface;

class Download extends Action\Action
{
    private $fileRepository;

    /**
     * @var DownloadHelper
     */
    private $downloadHelper;
    /**
     * @var Session
     */
    private $customerSession;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var attachmentFactory
     */
    private $attachmentFactory;
    protected $_dir;
    protected $_downloader;

    public function __construct(
        DownloadHelper $downloadHelper,
        StoreManagerInterface $storeManager,
        Session $customerSession,
        Action\Context $context,
        \MagePrakash\ProductAttachment\Model\AttachmentFactory $attachmentFactory,
        \Magento\Framework\Filesystem\DirectoryList $dir,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory        
    ) {
        parent::__construct($context);
                $this->_downloader =  $fileFactory;

        $this->downloadHelper    = $downloadHelper;
        $this->customerSession   = $customerSession;
        $this->storeManager      = $storeManager;
        $this->attachmentFactory = $attachmentFactory;
        $this->_dir = $dir;

    }

    /**
     * @param FileInterface $file
     */
    public function download($attachmentId)
    {
        $attachment = $this->attachmentFactory->create()->load($attachmentId);

        $filePath = $this->_dir->getPath('media').DIRECTORY_SEPARATOR.Directory::MagePrakash_DIRECTORY_ATTACHMENT.$attachment->getFilepath();

        return ['file_name'=>$attachment->getFilepath(),'file_path'=>$filePath];
    }

    public function execute()
    {
        $attachmentId = $this->getRequest()->getParam('attachment_id', 0);
        if ($attachmentId) {
             $data = $this->download($attachmentId);
        }
       
        return $this->_downloader->create(
            $data['file_name'],
            @file_get_contents($data['file_path'])
        );
       // return $this->resultFactory->create(ResultFactory::TYPE_FORWARD)->forward('noroute');
    }
}
