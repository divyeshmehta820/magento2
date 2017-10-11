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

namespace Parks\Dealer\Controller\Adminhtml;


use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

abstract class Details extends \Magento\Backend\App\Action
{
    /**
     * Post Factory
     * 
     * @var \Parks\Dealer\Model\DealerFactory
     */
    protected $_dealerFactory;

    /**
     * Core registry
     * 
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory = false;

     /**
     * Page factory
     * 
     * @var \Magento\Backend\Model\View\Result\Page
     */
    protected $_resultPage;

   
    /**
     * constructor
     * 
     * @param \Parks\Dealer\Model\DealerFactory $dealerFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\Model\View\Result\RedirectFactory $resultRedirectFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Parks\Dealer\Model\DealerFactory $dealerFactory,
        \Magento\Framework\Registry $coreRegistry,    
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {        
        parent::__construct($context);
        $this->_dealerFactory         = $dealerFactory;
        $this->_coreRegistry          = $coreRegistry; 
        $this->_resultPageFactory = $resultPageFactory;  
    }
    
    /**
     * Check is allowed access
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Parks_Dealer::details');
    }
    
}