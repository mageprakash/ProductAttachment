<?php declare(strict_types=1);


namespace MagePrakash\ProductAttachment\Model\ResourceModel;


class AttachmentRuleIdx extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('mageprakash_productattachment_attachment_rule_idx', 'id');
    }
}

