<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * {@inheritdoc}
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        
        $this->attachmentTable($setup);
        $this->ruleTable($setup);
        $this->productAttachmentRelationTable($setup);
        $this->iconTable($setup);
    }


    public function ruleTable($setup){
        
            $ruleTable = $setup->getConnection()->newTable(
            $setup->getTable('mageprakash_productattachment_attachment_rule_idx'))
            ->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Id'
            )->addColumn(
                'rule_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Rule Id'
            )->addColumn(
                'product_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Product Id'
            )->addColumn(
                'store_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Store id'
            )->addIndex(
                    $setup->getIdxName(
                        $setup->getTable('mageprakash_productattachment_attachment_rule_idx'),
                        ['store_id']
                    ),
                    ['store_id']
            )->addIndex(
                $setup->getIdxName(
                    $setup->getTable('mageprakash_productattachment_attachment_rule_idx'),
                    ['rule_id']
                ),
                ['rule_id']
            )->addIndex(
                $setup->getIdxName(
                $setup->getTable('mageprakash_productattachment_attachment_rule_idx'),
                ['product_id']
                ),
                ['product_id']
            )->setComment(
                'MagePrakash Attachment Rules Index'
            );

            $setup->getConnection()->createTable($ruleTable);
    }

    public function attachmentTable($setup){
        $table_mageprakash_productattachment_attachment = $setup->getConnection()->newTable($setup->getTable('mageprakash_productattachment_attachment'));

        $table_mageprakash_productattachment_attachment->addColumn(
            'attachment_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true,'nullable' => false,'primary' => true,'unsigned' => true,],
            'Entity ID'
        );

        $table_mageprakash_productattachment_attachment->addColumn(
            'filename',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => False],
            'filename'
        );

        $table_mageprakash_productattachment_attachment->addColumn(
            'icon_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            10,
            ['nullable' => False],
            'icon_id'
        );

        $table_mageprakash_productattachment_attachment->addColumn(
            'is_enable',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => False],
            'is_enable'
        );

        $table_mageprakash_productattachment_attachment->addColumn(
            'customer_groups',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => False],
            'customer_groups'
        );

        $table_mageprakash_productattachment_attachment->addColumn(
            'store_ids',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => False],
            'store_ids'
        );

        $table_mageprakash_productattachment_attachment->addColumn(
            'position',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['nullable' => False],
            'position'
        );

        $table_mageprakash_productattachment_attachment->addColumn(
            'filepath',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => False],
            'filepath'
        );

        $table_mageprakash_productattachment_attachment->addColumn(
            'size',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => False],
            'size'
        );

        $table_mageprakash_productattachment_attachment->addColumn(
            'type',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => False],
            'type'
        );

        $table_mageprakash_productattachment_attachment->addColumn(
            'attachment_scope',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => False],
            'attachment_scope'
        );

        $table_mageprakash_productattachment_attachment->addColumn(
                'conditions_serialized',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '64k',
                ['nullable' => true, 'default' => ''],
                'Conditions'
        );
        
        $setup->getConnection()->createTable($table_mageprakash_productattachment_attachment);
    }

    public function productAttachmentRelationTable($setup){
        $table_mageprakash_productattachment_product = $setup->getConnection()->newTable($setup->getTable('mageprakash_productattachment_product'));

        $table_mageprakash_productattachment_product->addColumn(
            'product_attachment_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true,'nullable' => false,'primary' => true,'unsigned' => true,],
            'Entity ID'
        );

        $table_mageprakash_productattachment_product->addColumn(
            'product_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['nullable' => False],
            'product_id'
        );

        $table_mageprakash_productattachment_product->addColumn(
            'attachment_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['nullable' => False],
            'attachment_id'
        );

        $setup->getConnection()->createTable($table_mageprakash_productattachment_product);
    }

    public function iconTable($setup){
        $table_mageprakash_productattachment_icon = $setup->getConnection()->newTable($setup->getTable('mageprakash_productattachment_icon'));

        $table_mageprakash_productattachment_icon->addColumn(
            'icon_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true,'nullable' => false,'primary' => true,'unsigned' => true,],
            'Entity ID'
        );
    
    
        $table_mageprakash_productattachment_icon->addColumn(
            'image',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => False],
            'image'
        );

        $table_mageprakash_productattachment_icon->addColumn(
            'is_active',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => False],
            'is_active'
        );

        $table_mageprakash_productattachment_icon->addColumn(
            'icon_extension',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => False],
            'icon_extension'
        );

        $setup->getConnection()->createTable($table_mageprakash_productattachment_icon);
    }
}
