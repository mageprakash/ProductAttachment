<?php declare(strict_types=1);


namespace MagePrakash\ProductAttachment\Model\ResourceModel\AttachmentRuleIdx;


class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \MagePrakash\ProductAttachment\Model\AttachmentRuleIdx::class,
            \MagePrakash\ProductAttachment\Model\ResourceModel\AttachmentRuleIdx::class
        );
    }
}

