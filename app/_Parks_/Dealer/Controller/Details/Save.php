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

namespace Parks\Dealer\Controller\Details;

use Magento\Framework\View\Result\PageFactory;


class Save extends \Magento\Framework\App\Action\Action
{
    const EMAIL_TEMPLATE = 'dealer/dealer/adminemailtemplate';
    /**
     * @var DealerFactory
     */
	protected $dealerFactory;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;      

    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $_transportBuilder;

    /**
     * @var \Magento\Framework\Translate\Inline\StateInterface
     */
    protected $_inlineTranslation;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;


    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Parks\Dealer\Model\DealerFactory $dealerFactory
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
	public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Parks\Dealer\Model\DealerFactory $dealerFactory,
        PageFactory $resultPageFactory	  
    )
    {       
        parent::__construct($context);         
        $this->dealerFactory = $dealerFactory; 
        $this->resultPageFactory = $resultPageFactory;
        $this->_transportBuilder = $transportBuilder;
        $this->_inlineTranslation = $inlineTranslation;
        $this->_scopeConfig = $scopeConfig;
        $this->_storeManager = $storeManager;   
    }


    public function execute()
    {
        try {
            /* Save Dealer */
            $data = $this->getRequest()->getParams();          

            $dealer = $this->dealerFactory->create();             
            $dealer->setData($data);
            $dealer->save();

            $postObject = new \Magento\Framework\DataObject();
            $senderName = $dealer->getName();
            $senderEmail = $dealer->getEmail();

            $data['name']= $dealer->getName();
            $data['email']= $dealer->getEmail();
            $data['details']= $dealer->getDetails();


            $postObject->setData($data);

            $sender = [
               'name' => $senderName,
               'email' => $senderEmail,
            ];    

            $to_name = $this->getSalesName();            
            $to_email = $this->getSalesEmail();
             // send mail to recipients
            $this->_inlineTranslation->suspend();
            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $transport = $this->_transportBuilder->setTemplateIdentifier(
                            $this->_scopeConfig->getValue(
                                    self::EMAIL_TEMPLATE,
                                          $storeScope
                                    )
                    )->setTemplateOptions(
                       [
                           'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                           'store' => $this->_storeManager
                                      ->getStore()
                                      ->getId(),
                                ]
                    )->setTemplateVars(['data' => $postObject])
                    ->setFrom($sender)
                    ->addTo($to_email, $to_name)
                    ->getTransport();
            $transport->sendMessage();
               
            $this->_inlineTranslation->resume();  
            $this->messageManager->addSuccess(__('Dealer details successfully saved.'));

        } catch (Exception $e) {
            $this->messageManager->addError(__('Error occurred during dealer creation.'));
        }
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('dealer/details');
        return $resultRedirect;
    }
    protected function getSalesEmail()
    {
        return $this->_scopeConfig->getValue(
            'trans_email/ident_sales/email',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    protected function getSalesName()
    {
        return $this->_scopeConfig->getValue(
            'trans_email/ident_sales/name',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}