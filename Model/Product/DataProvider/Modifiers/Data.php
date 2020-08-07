<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Model\Product\DataProvider\Modifiers;

use Magento\Catalog\Model\Locator\LocatorInterface;

class Data
{
    /**
    * @var LocatorInterface
    */
    private $locator;
    
    /**
    * @var Product
    */
    private $product;

    public function __construct(
         LocatorInterface $locator,
         \MagePrakash\ProductAttachment\Model\AttachmentManagement $product
    ) {
        $this->locator = $locator;
        $this->product = $product;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function execute(array $data)
    {
        $storeId = $this->locator->getStore()->getId();
        $productBaseItem    = $this->product->getMatchingAttachmentByProductBase($this->locator->getProduct()->getId(),$storeId);

         $conditionBaseItem    = $this->product->getMatchingAttachmentByConditionBase($this->locator->getProduct()->getId(),$storeId);
         
        $data[$this->locator->getProduct()->getId()]['productbase']['productattachments'] = $productBaseItem;
        $data[$this->locator->getProduct()->getId()]['conditionbase']['conditionbaseattachments'] = $conditionBaseItem;
        
        return $data;
    }
}
