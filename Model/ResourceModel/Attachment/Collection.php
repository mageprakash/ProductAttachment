<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Model\ResourceModel\Attachment;

class Collection extends \Magento\Rule\Model\ResourceModel\Rule\Collection\AbstractCollection
{  
    /**
     * @var string
     */
    protected $_idFieldName = 'attachment_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \MagePrakash\ProductAttachment\Model\Attachment::class,
            \MagePrakash\ProductAttachment\Model\ResourceModel\Attachment::class
        );
    }
    
    protected function _initSelect()
    {

        parent::_initSelect();
        $this->addFilterToMap('attachment_id', 'main_table.attachment_id');
        $this->getSelect()
        ->joinLeft(
            ['pa' => $this->getTable('mageprakash_productattachment_product')],
            'main_table.attachment_id = pa.attachment_id',
            [
                'product_ids' => 'group_concat(pa.product_id)'
            ]
        )->joinLeft(
            ['mageprakash_icon'    => $this->getTable('mageprakash_productattachment_icon')],
            'mageprakash_icon.icon_id = main_table.icon_id',
            [
               "icon_image" => 'mageprakash_icon.image'
            ]
        )->group('main_table.attachment_id');

       
        return $this;
    }

}
