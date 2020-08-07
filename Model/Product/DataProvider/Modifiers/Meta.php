<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Model\Product\DataProvider\Modifiers;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\ConfigurableProduct\Model\ResourceModel\Product\Type\Configurable;

class Meta
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var Configurable
     */
    private $configurableProduct;

    /**
     * @var LocatorInterface
     */
    private $locator;

    public function __construct(
        Configurable $configurableProduct,
        LocatorInterface $locator
    ) {
        $this->configurableProduct = $configurableProduct;
        $this->locator = $locator;
    }

    /**
     * @param array $meta
     *
     * @return array
     */
    public function execute($meta)
    {
        $isPartOfConfigurable = (bool)$this->configurableProduct->getParentIdsByChild(
            $this->locator->getProduct()->getId()
        );

        if ($isPartOfConfigurable) {
            $meta['productbase']['arguments']['data']['config']['visible'] = false;
            $meta['productbase']['arguments']['data']['config']['disabled'] = true;

            $meta['conditionbase']['arguments']['data']['config']['visible'] = false;
            $meta['conditionbase']['arguments']['data']['config']['disabled'] = true;
        }

        return $meta;
    }
}
