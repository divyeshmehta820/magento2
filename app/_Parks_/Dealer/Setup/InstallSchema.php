<?php
/**
 * Parks
 *
 * NOTICE OF LICENSE
 *
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Parks
 * @package     Parks_Dealer
 * 
 */

namespace Parks\Dealer\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Module\Setup\Migration;
use Magento\Customer\Model\GroupFactory;


/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    protected $groupFactory;

    public function __construct(GroupFactory $groupFactory) {
        $this->groupFactory = $groupFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        /**
         *  Create dealer customer group
        */
         
        $group = $this->groupFactory->create();
        $group->setCode('Dealer')->setTaxClassId(3)->save();


        /**
         * Create table 'dealer_details'
         */
        $table = $installer->getConnection()
            ->newTable($installer->getTable('dealer_details'))
            ->addColumn(
                'details_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Dealer ID'
            )
            ->addColumn(
                'name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false, 'default' => ''],
                'Dealer Name'
            )
            ->addColumn(
                'email',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false, 'default' => ''],
                'Dealer Email'
            )
            ->addColumn(
                'details',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                ['nullable' => false, 'default' => ''],
                'Dealer Details'
            )           
            ->addColumn(
                'is_reject',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['nullable' => false, 'default' => '0'],
                'Is Active'
            )
            ->addColumn(
                'created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                'Created At'
            )->addColumn(
                'updated_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                'Updated At'
            )->addIndex(
                $installer->getIdxName('dealer_details', ['details_id']),
                ['details_id']
            )
            ->setComment('Dealer Details Table');
            
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
