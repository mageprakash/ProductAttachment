<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Model;

use Magento\Framework\UrlInterface;

class FileUploader
{
    /**
     * @var \MagePrakash\ProductAttachment\Model\Icon\ResourceModel\Icon
     */
    private $iconResourceModel;

    /**
     * @var \MagePrakash\ProductAttachment\Model\Icon\GetIconForFile
     */
    private $getIconForFile;

    /**
     * @var \Magento\Backend\Model\Session
     */
    private $session;

    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    /**
     * @var \Magento\MediaStorage\Model\File\UploaderFactory
     */
    private $uploaderFactory;

    /**
     * @var \Magento\Framework\Filesystem\Directory\WriteInterface
     */
    private $mediaDirectory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $icon;

    public function __construct(
        \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Backend\Model\Session $session,
        \Magento\Framework\Registry $registry,
        \MagePrakash\ProductAttachment\Model\ResourceModel\Icon $icon
    ) {
        $this->icon = $icon;
        $this->session = $session;
        $this->registry = $registry;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(
            \Magento\Framework\App\Filesystem\DirectoryList::MEDIA
        );
        $this->uploaderFactory = $uploaderFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * @param string $fileKey
     *
     * @return array|string[]
     */
    public function uploadFile($fileKey,$type)
    {

        $iconsList = $this->icon->getListIconExtensionWithId();

        try {
            
            $uploader = $this->uploaderFactory->create(['fileId' => $fileKey]);
            
            $path = Directory::MagePrakash_DIRECTORY_ATTACHMENT;
            $iconPath = Directory::MagePrakash_DIRECTORY_ICON;
            
            if($type == "icon")
            {
               $path = Directory::MagePrakash_DIRECTORY_ICON;
            }

            $uploader->setAllowRenameFiles(true);
            $result = $uploader->save($this->mediaDirectory->getAbsolutePath($path));

            unset($result['path']);

            if (!$result) {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('File can not be saved to the destination folder.')
                );
            }

            $iconDetails = isset($iconsList[pathinfo($result['name'], PATHINFO_EXTENSION)])?$iconsList[pathinfo($result['name'], PATHINFO_EXTENSION)]:'';

            $result['previewUrl'] = "";
            $result['icon_id'] 	  = "";

            if(isset($iconDetails['icon_id'])){
              
				$result['icon_id'] 	  = $iconDetails['icon_id'];
                $result['previewUrl'] = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA)
                .$iconPath.$iconDetails['image'];
            }
            $result['tmp_name'] = str_replace('\\', '/', $result['tmp_name']);
            $result['url'] = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA).$path.$result['file'];
            
            $result['filepath']         = $result['file'];
            $this->setResultCookie($result);
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }

        return $result;
    }

    /**
     * @param array|string[] $result
     */
    private function setResultCookie(&$result)
    {
        $result['cookie'] = [
            'name' => $this->session->getName(),
            'value' => $this->session->getSessionId(),
            'lifetime' => $this->session->getCookieLifetime(),
            'path' => $this->session->getCookiePath(),
            'domain' => $this->session->getCookieDomain(),
        ];
    }
}
