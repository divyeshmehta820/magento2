<?php

namespace Indianic\Adminlog\Controller;

class Sendemail extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $_request;
    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $_transportBuilder;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    public function __construct(
        \Magento\Framework\App\Action\Context $context
        , \Magento\Framework\App\Request\Http $request
        , \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
        , \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_request          = $request;
        $this->_transportBuilder = $transportBuilder;
        $this->_storeManager     = $storeManager;
        parent::__construct($context);
    }

    /*public function execute()
    {
        $post = $this->getRequest()->getPostValue();
        $this->inlineTranslation->suspend();
        $objectManager   = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->create('Magento\Customer\Model\Session');
        try {
            $postObject      = new \Magento\Framework\DataObject();
            $post['myname']  = $customerSession->getCustomer()->getName(); //Loggedin customer Name
            $post['myemail'] = $customerSession->getCustomer()->getEmail(); //Loggedin customer Email
            $postObject->setData($post);
            $myname  = $post['myname'];
            $myemail = $post['myemail'];
            $sender  = [
                'name'  => $this->_escaper->escapeHtml($myname),
                'email' => $this->_escaper->escapeHtml($myemail),
            ];
            $sentToEmail  = $this->scopeConfig->getValue('trans_email/ident_support/email', ScopeInterface::SCOPE_STORE);
            $sentToname   = $this->scopeConfig->getValue('trans_email/ident_support/name', ScopeInterface::SCOPE_STORE);
            $senderToInfo = [
                'name'  => $this->_escaper->escapeHtml($sentToname),
                'email' => $this->_escaper->escapeHtml($sentToEmail),
            ];
            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $transport  = $this->_transportBuilder
                ->setTemplateIdentifier('mymodule_email_template') // My email template
                ->setTemplateOptions([
                    'area'  => \Magento\Framework\App\Area::AREA_FRONTEND, // this is using frontend area to get the template file if admin then \Magento\Backend\App\Area\FrontNameResolver::AREA_CODE
                    'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                ])
                ->setTemplateVars(['data' => $postObject])
                ->setFrom($sender)
                ->addTo($senderToInfo)
                ->addBcc($senderBcc)
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
            $this->messageManager->addSuccess(__('Thanks'));
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setRefererOrBaseUrl();
            return $resultRedirect;
        } catch (\Exception $e) {
            $this->inlineTranslation->resume();
            $this->messageManager->addError(__('Try again'));
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setRefererOrBaseUrl();
            return $resultRedirect;
        }
    }*/

    public function execute()
    {
        $store     = $this->_storeManager->getStore()->getId();
        $transport = $this->_transportBuilder->setTemplateIdentifier('adminlog_login_success')
            ->setTemplateOptions(['area' => 'frontend', 'store' => $store]) //'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID // 'area'  => \Magento\Framework\App\Area::AREA_FRONTEND,
            ->setTemplateVars(
                [
                    'store' => $this->_storeManager->getStore(),
                ]
            )
            ->setFrom('general')
        // you can config general email address in Store -> Configuration -> General -> Store Email Addresses
            ->addTo('divyesh.mehta@Indianic.com', 'Divyesh Mehta')
            ->getTransport();
        $transport->sendMessage();
        return $this;
    }
}
