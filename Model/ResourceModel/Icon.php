<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Model\ResourceModel;

class Icon extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('mageprakash_productattachment_icon', 'icon_id');
    }

    public function getListIconExtension()
    {
        $result = [];

    	$select = $this->getConnection()->select()
            ->from(['fsp' => $this->getMainTable()], [
                '*'
            ]);

        if ($collection = $this->getConnection()->fetchAll($select)) {
            foreach ($collection as $key => $value) {
                $result[$value['icon_id']] = $value['icon_extension'];
            }
            return $result;
        }
        return [];
    }

     public function getListIconExtensionWithId()
    {
        $result = [];

        $select = $this->getConnection()->select()
            ->from(['fsp' => $this->getMainTable()], [
                '*'
            ]);

        if ($collection = $this->getConnection()->fetchAll($select)) {
            foreach ($collection as $key => $value) {
                foreach (explode(",", $value['icon_extension']) as $extension) {

                    $result[$extension] = ["icon_id" => $value['icon_id'],"image" => $value['image']];
                }
            }
            return $result;
        }
        return [];
    }
}
