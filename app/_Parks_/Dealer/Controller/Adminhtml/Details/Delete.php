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

namespace Parks\Dealer\Controller\Adminhtml\Details;

use Magento\Backend\App\Action;
 
class Delete extends Action
{

    const EMAIL_TEMPLATE = 'dealer/dealer/emailtemplate';
    /**
     * 
     * @var  \Parks\Dealer\Model\Dealer
     */
    protected $_model;

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
     * @param Action\Context $context
     * @param \Parks\Dealer\Model\Dealer $model
     */
    public function __construct(
        Action\Context $context,
        \Parks\Dealer\Model\Dealer $model,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->_model = $model;
        $this->_transportBuilder = $transportBuilder;
        $this->_inlineTranslation = $inlineTranslation;
        $this->_scopeConfig = $scopeConfig;
        $this->_storeManager = $storeManager;
    } 
   
 
    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                
                $model = $this->_model;
                $model->load($id);  
                $model->setIsReject(1);
                $model->save();              

                $postObject = new \Magento\Framework\DataObject();
                $senderName = $this->getSalesName();
                $senderEmail = $this->getSalesEmail();

                $data['name']= $model->getName();
                $data['email']= $model->getEmail();
                $data['details']= $model->getDetails();


                $postObject->setData($data);

                $sender = [
                    'name' => $senderName,
                    'email' => $senderEmail,
                ];                
               
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
                        ->addTo($model->getEmail(), $model->getName())
                        ->getTransport();
                $transport->sendMessage();
               
                $this->_inlineTranslation->resume();                  

                /* Set dealer reject flag */

                
                
                $this->messageManager->addSuccess(__('Dealer has been successfully rejected.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->_inlineTranslation->resume(); 
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        $this->messageManager->addError(__('Delear does not exist'));
        return $resultRedirect->setPath('*/*/');
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