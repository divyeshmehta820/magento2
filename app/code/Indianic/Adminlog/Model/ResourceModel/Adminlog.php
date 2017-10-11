<?php
/**
 * Copyright © 2015 Indianic. All rights reserved.
 */
namespace Indianic\Adminlog\Model\ResourceModel;

/**
 * Adminlog resource
 */
class Adminlog extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('adminlog_adminlog', 'id');
    }

  
}
