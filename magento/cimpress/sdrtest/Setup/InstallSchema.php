<?php

namespace cimpress\sdrtest\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        /**
         * Create table 'widget'
         */
        if (!$installer->getConnection()->isTableExists($installer->getTable('customer_upload'))) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('customer_upload')
            )->addColumn(
                'upload_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Upload Id'
            )->addColumn(
                'filename',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Filename of upload'
            )->addColumn(
                'customer_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [],
                'Customer Id'
            )->addColumn(
                'data',
                \Magento\Framework\DB\Ddl\Table::TYPE_BLOB,
                '64k',
                [],
                'Data'
            )->addColumn(
                'item_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['nullable'=>true],
                'Item Id'
            )->addIndex(
                $installer->getIdxName('customer_id','item_id'),
                'customer_id'
            )->setComment(
                'Customer Uploads'
            );
            $installer->getConnection()->createTable($table);
        } 

        $installer->endSetup();

    }
}
