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

class MassReject extends \Magento\Backend\App\Action
{

    const EMAIL_TEMPLATE = 'dealer/dealer/emailtemplate';
    /**
     * Mass Action Filter
     * 
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    protected $_filter;

    /**
     * Collection Factory
     * 
     * @var \Parks\Dealer\Model\ResourceModel\Dealer\CollectionFactory
     */
    protected $_collectionFactory;

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
     * constructor
     * 
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \Parks\Dealer\Model\ResourceModel\Dealer\CollectionFactory $collectionFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Parks\Dealer\Model\ResourceModel\Dealer\CollectionFactory $collectionFactory,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->_filter            = $filter;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context);
        $this->_transportBuilder = $transportBuilder;
        $this->_inlineTranslation = $inlineTranslation;
        $this->_scopeConfig = $scopeConfig;
        $this->_storeManager = $storeManager;
    }


    /**
     * execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $collection = $this->_filter->getCollection($this->_collectionFactory->create());

        $delete = 0;
        foreach ($collection as $item) {
            /** @var \Parks\Dealer\Model\Dealer $item */
            $item->setIsReject(1);
            $item->save();

            $postObject = new \Magento\Framework\DataObject();
            $senderName = $this->getSalesName();
            $senderEmail = $this->getSalesEmail();

            $data['name']= $item->getName();
            $data['email']= $item->getEmail();
            $data['details']= $item->getDetails();


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
                        ->addTo($item->getEmail(), $item->getName())
                        ->getTransport();
            $transport->sendMessage();
               
            $this->_inlineTranslation->resume();    

            $delete++;
        }
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been rejected.', $delete));
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
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
