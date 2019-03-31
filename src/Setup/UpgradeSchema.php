<?php
/**
 * Copyright © Magepotato. All rights reserved.
 */
namespace Magepotato\Banners\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function upgrade(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();

        if (version_compare($context->getVersion(), '0.0.2') < 0) {
            /**
             * Create areas table mpotato_banners_area.
             */
            $table = $installer->getConnection()->newTable(
                $installer->getTable('mpotato_banners_area')
            )->addColumn(
                'entity_id',
                Table::TYPE_SMALLINT,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Area ID'
            )->addColumn(
                'title',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Area Title'
            )->addColumn(
                'identifier',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Area String Identifier'
            )->addColumn(
                'is_active',
                Table::TYPE_BOOLEAN,
                null,
                ['nullable' => false, 'default' => '1'],
                'Is Area Active'
            )->addIndex(
                $installer->getIdxName(
                    $installer->getTable('mpotato_banners_area'),
                    ['entity_id', 'identifier'],
                    AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ['entity_id', 'identifier'],
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            )->addIndex(
                $setup->getIdxName(
                    $installer->getTable('mpotato_banners_area'),
                    ['title', 'identifier'],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['title', 'identifier'],
                ['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
            )->setComment(
                'Magepotato Banners Area Table'
            );
            $installer->getConnection()->createTable($table);
            /**
             * Create banners table mpotato_banners_banner.
             */
            $table = $installer->getConnection()->newTable(
                $installer->getTable('mpotato_banners_banner')
            )->addColumn(
                'entity_id',
                Table::TYPE_SMALLINT,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Banner ID'
            )->addColumn(
                'title',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Banner Title'
            )->addColumn(
                'type_id',
                Table::TYPE_SMALLINT,
                null,
                ['nullable' => false],
                'Banner type ID (Product, Category, External,... etc)'
            )->addColumn(
                'is_active',
                Table::TYPE_BOOLEAN,
                null,
                ['nullable' => false, 'default' => '1'],
                'Is Banner Active'
            )->addColumn(
                'sort_order',
                Table::TYPE_SMALLINT,
                null,
                ['nullable' => false, 'default' => '0'],
                'Banner Sort Order'
            )->addColumn(
                'area_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => true],
                'Banner Area ID'
            )->addColumn(
                'store_ids',
                Table::TYPE_TEXT,
                255,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Store View IDs'
            )->addColumn(
                'link',
                Table::TYPE_TEXT,
                255,
                ['nullable' => true],
                'Banner link. Could be an id or a link'
            )->addColumn(
                'link_target',
                Table::TYPE_TEXT,
                255,
                ['nullable' => true],
                'Target attribute specifies where to open the linked document'
            )->addColumn(
                'alt_text',
                Table::TYPE_TEXT,
                255,
                ['nullable' => true],
                'Alternative text for the image in the slider'
            )->addColumn(
                'image',
                Table::TYPE_TEXT,
                255,
                ['nullable' => true],
                'Banner featured image'
            )->addColumn(
                'content',
                Table::TYPE_TEXT,
                '64k',
                ['nullable' => true],
                'Banner caption/content'
            )->addColumn(
                'creation_time',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                'Banner Creation Time'
            )->addColumn(
                'update_time',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
                'Banner Modification Time'
            )->addIndex(
                $installer->getIdxName('mpotato_banners_banner', ['entity_id']),
                ['entity_id']
            )->addForeignKey(
                $installer->getFkName(
                    'mpotato_banners_banner',
                    'area_id',
                    'mpotato_banners_area',
                    'entity_id'
                ),
                'area_id',
                $installer->getTable('mpotato_banners_area'),
                'entity_id',
                Table::ACTION_CASCADE
            )->setComment(
                'Magepotato Banners Banner Table'
            );
            $installer->getConnection()->createTable($table);
        }

        $installer->endSetup();
    }
}
