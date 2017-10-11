<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Indianic\Adminlog\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Catalog\Model\ResourceModel\Product\Gallery;
use Magento\Catalog\Model\Product\Attribute\Backend\Media\ImageEntryConverter;

/**
 * Upgrade the Catalog module DB scheme
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    
     public function upgrade(SchemaSetupInterface $setup,
                            ModuleContextInterface $context){

        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.0.1') < 0) {

             $setup->startSetup();
             $setup->getConnection()->addColumn(
             $setup->getTable('adminlog_adminlog'),
             'status',
             ['type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
             'length' => '55',
             'nullable' => false,
             'default' => '0',
             'comment' => 'status']);
         $setup->endSetup();
        }

        if (version_compare($context->getVersion(), '1.0.2') < 0) {

             $setup->startSetup();
             $setup->getConnection()->addColumn(
             $setup->getTable('adminlog_adminlog'),
             'login_time',
             ['type' => \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
             'length' => null,
             'nullable' => false,
             'default' => '0',
             'comment' => 'login_time']);
         $setup->endSetup();
        }


        if(version_compare($context->getVersion(),'1.0.3') < 0)
        {

             $setup->startSetup();
             $setup->getConnection()->addColumn(
             $setup->getTable('quote_item'),
             'remark',
             ['type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
             'nullable' => false,
             'comment' => 'remark']);
            $setup->endSetup();

        }

        if(version_compare($context->getVersion(),'1.0.4') < 0)
        {

             $setup->startSetup();
             $setup->getConnection()->addColumn(
             $setup->getTable('sales_order_item'),
             'remark',
             ['type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
             'nullable' => false,
             'comment' => 'remark']);
            $setup->endSetup();

        }

        if (version_compare($context->getVersion(), '1.0.5' < 0)) {

          $setup->startSetup();
          $setup->getConnection()->addColumn(
              $setup->getTable('quote'),
              'message',
              [
                  'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                  'nullable' => false,
                  'comment' => 'Message Column',
             ]
          );
        }


        if (version_compare($context->getVersion(), '1.0.6' < 0)) {

          $setup->startSetup();
          $setup->getConnection()->addColumn(
              $setup->getTable('sales_order'),
              'message',
              [
                  'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                  'nullable' => false,
                  'comment' => 'Message Column',
             ]
          );
        }

        if (version_compare($context->getVersion(), '1.0.7' < 0)) {

          $setup->startSetup();
          $setup->getConnection()->addColumn(
              $setup->getTable('admin_user'),
              'ip_address',
              [
                  'length' => 225,
                  'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                  'nullable' => false,
                  'comment' => 'Ip Column',
             ]
          );
        }


        $setup->endSetup();
    }
}
