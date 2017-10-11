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
namespace Parks\Dealer\Controller\Adminhtml\Details ;

class Index extends \Magento\Backend\App\Action
{	

	/**
     * @var \Magento\Framework\View\Result\PageFactory
     */
	protected $resultPageFactory = false;

	 /**
     * Page factory
     * 
     * @var \Magento\Backend\Model\View\Result\Page
     */
    protected $_resultPage;

	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory
	) {
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
	}

	public function execute()
	{
		//Call page factory to render layout and page content
		$this->_setPageData();
        return $this->getResultPage();
	}

	/*
	 * Check permission via ACL resource
	 */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Parks_Dealer::details');
	}

    public function getResultPage()
    {
        if (is_null($this->_resultPage)) {
            $this->_resultPage = $this->resultPageFactory->create();
        }
        return $this->_resultPage;
    }

    protected function _setPageData()
    {
        $resultPage = $this->getResultPage();
        $resultPage->setActiveMenu('Parks_Dealer::details');
        $resultPage->getConfig()->getTitle()->prepend((__('Dealer Details')));

        //Add bread crumb
        $resultPage->addBreadcrumb(__('Dealer'), __('Dealer'));
        $resultPage->addBreadcrumb(__('Details'), __('Details'));

        return $this;
    }
}
