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

namespace Parks\Dealer\Model\ResourceModel;

class Dealer extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	
	 /**
     * DB connection
     *
     * @var \Magento\Framework\DB\Adapter\AdapterInterface
     */
    protected $connection;



    /**
     * Construct
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context     
     * @param string $connectionName
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
    }

    /**
     * Initialize resource model
     * Get tablename from config
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('dealer_details', 'details_id');
    }
}