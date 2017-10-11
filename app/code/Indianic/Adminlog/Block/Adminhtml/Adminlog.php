<?php
namespace Indianic\Adminlog\Block\Adminhtml;

class Adminlog extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
		
        $this->_controller = 'adminhtml_adminlog';/*block grid.php directory*/
        $this->_blockGroup = 'Indianic_Adminlog';
        $this->_headerText = __('Adminlog');
        //$this->_addButtonLabel = __('Add New Entry'); 
        parent::_construct();
         $this->removeButton('add');
		
    }
}
