<?php

namespace Rvs\CustomerGroup\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Zend_Db_Exception;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $table = $installer->getConnection()
            ->newTable($installer->getTable('rvs_customer_group_rule'))
            ->addColumn('group_id', Table::TYPE_INTEGER, null, [
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary'  => true
            ], 'Entity ID')
            ->addColumn('email_domain', Table::TYPE_TEXT, 255, ['nullable' => true], 'Email Domain or Email')
            ->addColumn('domain', Table::TYPE_SMALLINT, null, ['nullable' => false], 'Domain')
            ->addColumn('single_email', Table::TYPE_SMALLINT, null, ['nullable' => false], 'Single Email')
            ->addColumn('group', Table::TYPE_SMALLINT, null, ['nullable' => false], 'Customer Group')
            ->addColumn('status_id', Table::TYPE_SMALLINT, null, ['nullable' => false, 'default' => '0'], 'Status')
            ->setComment('Customer Group Change Rule');
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
