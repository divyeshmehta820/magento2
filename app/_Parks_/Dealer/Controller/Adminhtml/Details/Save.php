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
 
use Magento\Backend\App\Action;
use Magento\Customer\Api\AddressMetadataInterface;
use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Controller\RegistryConstants;
use Magento\Customer\Model\EmailNotificationInterface;
use Magento\Customer\Model\Metadata\Form;
use Magento\Framework\Exception\LocalizedException;
use Magento\Customer\Api\Data\CustomerInterfaceFactory ;
use Magento\Customer\Model\CustomerFactory ;
class Save extends Action
{
    /**
     * Customer Group
     *
     * @var \Magento\Customer\Model\ResourceModel\Group\Collection
     */
    protected $_customerGroup;


    /**
     * @var \Parks\Dealer\Model\Dealer
     */
    protected $_model;

    /**
     * @var \Parks\Dealer\Model\Dealer
     */
    protected $_storeManager;

    /**
     * @var \Magento\Customer\Model\AccountManagement
     */
    protected $customerAccountManagement;

    /**
     * @var \Magento\Customer\Api\Data\CustomerInterfaceFactory
     */
    protected $customerDataFactory;

    /**
     * @var \Magento\Customer\Model\CustomerFactory
     */
    protected $customerFactory;
 
    /**
     * @var \Magento\Framework\Math\Random
     */
    protected $_mathRandom;


    /**
     * @param Action\Context $context
     * @param \Parks\Dealer\Model\Dealer $model
     */
    public function __construct(
        Action\Context $context,
        \Parks\Dealer\Model\Dealer $model,
        \Magento\Customer\Model\ResourceModel\Group\Collection $customerGroup,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\AccountManagement $customerAccountManagement,
        \Magento\Customer\Api\Data\CustomerInterfaceFactory $customerDataFactory,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Framework\Math\Random $mathRandom
    ) {
        parent::__construct($context);
        $this->_model = $model;
        $this->_customerGroup = $customerGroup;
        $this->_storeManager = $storeManager;
        $this->customerAccountManagement = $customerAccountManagement;
        $this->customerDataFactory = $customerDataFactory;
        $this->customerFactory  = $customerFactory;
        $this->_mathRandom = $mathRandom;
    }
 
     
    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $data['details_id'];
        if($id) {
            try
            {
                $dealer = $this->_model->load($id);
                $customerGroups = $this->_customerGroup->toOptionArray();
                $websiteId  = $this->_storeManager->getWebsite()->getWebsiteId();
                
                foreach ($customerGroups as $groups) {
                    if($groups['label']=='Dealer'){
                        $groupId =  $groups['value'];
                        break;
                    }                   
                }
                $email = $dealer['email'];
                $storeId =$this->_storeManager->getStore()->getId();
                $firstname = $dealer['name'];
                $lastname = $dealer['name'];               
                $password = $this->_mathRandom->getRandomString(8);
                /*$customerData = array();
                $customerData['firstname'] = $dealer['name'];
                $customerData['lastname'] = $dealer['name'];
                $customerData['email'] = $dealer['email'];
                $customerData['website_id'] = $websiteId;
                $customerData['group_id'] = $groupId;
                $customerData['store_id'] =  $this->_storeManager->getStore()->getId();

                 /** @var CustomerInterface $customer */
                /* $customer = $this->customerDataFactory->create();
                $this->dataObjectHelper->populateWithArray(
                    $customer,
                    $customerData,
                    '\Magento\Customer\Api\Data\CustomerInterface'
                );
                $customer = $this->customerAccountManagement->createAccount($customer);*/
                $customer   = $this->customerFactory->create();
                $customer->setWebsiteId($websiteId);
                // Preparing data for new customer
                $customer->setEmail($email); 
                $customer->setFirstname($firstname);
                $customer->setLastname($lastname);
                $customer->setGroupId($groupId);
                $customer->setStoreId($storeId);
                $customer->setPassword($password);

                // Save customer data
                try{
                    $customer->save();
                    $customer->sendNewAccountEmail();
                    if($customer->getId())
                    {
                        $dealer->delete();
                    }
                }catch(Exception $e)
                {
                    $this->messageManager->addError($e->getMessage());
                    return $resultRedirect->setPath('*/*/');
                }
                
                $this->messageManager->addSuccess(__('Dealer has been successfully created.'));
                return $resultRedirect->setPath('*/*/');
          
            }catch(Exception $e)
            {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }

        }else{

            $this->messageManager->addError(__('Delear does not exist'));
            return $resultRedirect->setPath('*/*/');
        }       
        print_r($data);exit;
    }
}