<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Ui\Component\Form;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\ComponentVisibilityInterface;
use Magento\Ui\Component\Form\Fieldset;

/**
 * Class Fieldset
 * @package Custom\Custom\Ui\Component\Form
 */
class CustomFieldset extends Fieldset implements ComponentVisibilityInterface
{
    /**
     * CustomFieldset constructor.
     * @param ContextInterface $context
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        array $components = [],
        array $data = []
    ) {
        $this->context = $context;

        parent::__construct($context, $components, $data);
    }
    
    public function canShowTab()
    {
        return false;
    }
    
    public function isHidden()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isComponentVisible(): bool
    {
        $visible = false; //add logic
        return (bool)$visible;
    }
}
?>