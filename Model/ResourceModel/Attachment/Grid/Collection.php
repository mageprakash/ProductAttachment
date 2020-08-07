<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Model\ResourceModel\Attachment\Grid;

use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Psr\Log\LoggerInterface as Logger;

class Collection extends \Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult
{
    public function __construct(
        EntityFactory $entityFactory,
        Logger $logger,
        FetchStrategy $fetchStrategy,
        EventManager $eventManager,
        $mainTable = 'mageprakash_productattachment_attachment',
        $resourceModel = \MagePrakash\ProductAttachment\Model\ResourceModel\Attachment::class
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel);
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
            ['mageprakash_icon' => $this->getTable('mageprakash_productattachment_icon')],
            'mageprakash_icon.icon_id = main_table.icon_id',
            [
               "icon_image" => 'mageprakash_icon.image'
            ]
        )->group('main_table.attachment_id');

        return $this;
    }
}
