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
namespace Parks\Dealer\Model\ResourceModel\Dealer;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
     /**
     * @var string
     */
    protected $_idFieldName = 'details_id';
	/**
     * Constructor
     * Configures collection
     *
     * @return void
     */
    protected function _construct()
    {        
        $this->_init('Parks\Dealer\Model\Dealer', 'Parks\Dealer\Model\ResourceModel\Dealer');       
    }
}