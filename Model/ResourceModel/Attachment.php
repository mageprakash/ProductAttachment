<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Model\ResourceModel;

class Attachment extends \Magento\Rule\Model\ResourceModel\AbstractResource
{
    protected function _construct()
    {
        $this->_init('mageprakash_productattachment_attachment', 'attachment_id');
    }
}
