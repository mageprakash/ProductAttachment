<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Extension implements OptionSourceInterface
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $icon;

    public function __construct(
        \MagePrakash\ProductAttachment\Model\ResourceModel\Icon $icon
    ) {
        $this->icon = $icon;
    }

    public function toOptionArray()
    {
        $iconsList = $this->icon->getListIconExtension();
      //  $availableOptions = $this->getAvailableTypes();
        $options[] = ["value"=>"","label"=>"--Please Select --"];

        foreach ($iconsList as $key => $value) {
            $options[] = [
                "label" => $value,
                "value" => $key
            ];
        }
        return $options;
    }
}