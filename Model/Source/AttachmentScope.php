<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

class AttachmentScope implements OptionSourceInterface
{
    const PRODUCT_BASE = 1;
    const RULE_BASE    = 2;
    const BOTH         = 3;

    public function toOptionArray()
    {
        $availableOptions = $this->getAvailableTypes();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                "label" => $value,
                "value" => $key
            ];
        }
        return $options;
    }

    public function getAvailableTypes()
    {
        return [
            self::PRODUCT_BASE => __("Only Product Base"),
            self::RULE_BASE    => __("Only Rule Base"),
            self::BOTH         => __("Both")
        ];
    }
}