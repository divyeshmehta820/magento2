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
namespace Parks\Dealer\Block;

use Magento\Catalog\Helper\Data;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\Store;

class Breadcrumbs extends \Magento\Framework\View\Element\Template
{
    

    /**
     * @param Context $context     
     * @param array $data
     */
    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }
    
    /**
     * Preparing layout
     *
     * @return \Magento\Catalog\Block\Breadcrumbs
     */
    protected function _prepareLayout()
    {
        if ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumbsBlock->addCrumb(
                'home',
                [
                    'label' => __('Home'),
                    'title' => __('Go to Home Page'),
                    'link' => $this->_storeManager->getStore()->getBaseUrl()
                ]
            );
            $breadcrumbsBlock->addCrumb('dealer/details', ['label' => 'Become A Dealer', 'title' => 'Become A Dealer']);
        }       
            
        return parent::_prepareLayout();
    }
}
