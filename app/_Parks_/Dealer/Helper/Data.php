<?php
/**
 * Park Health Products
 * Park Health Dealer Extension
 *
 * @category   Parks
 * @package    Parks_Dealer
 */
namespace Parks\Dealer\Helper;


use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Helper\View as CustomerViewHelper;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ObjectManager;


class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

	
    /**
     * Customer session
     *
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var \Magento\Customer\Helper\View
     */
    protected $_customerViewHelper;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var array
     */

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        CustomerViewHelper $customerViewHelper,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
    	$this->_customerSession = $customerSession;
        $this->_customerViewHelper = $customerViewHelper;
        $this->_storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * Get config value
     */
    public function getConfigValue($value = '') {
        return $this->scopeConfig
                ->getValue(
                        $value,
                        \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                        );
    }

    /**
     * Get base url
     */
    public function getBaseUrl() {
        return $this->_storeManager
                ->getStore()
                ->getBaseUrl(
                        \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                        );
    }

    /**
     * Get current url
     */
    public function getCurrentUrls() {
        return $this->_urlBuilder->getCurrentUrl();
    }

    /**
     * Get user name
     *
     * @return string
     */
    public function getUserName()
    {
        if (!$this->_customerSession->isLoggedIn()) {
            return '';
        }
        /**
         * @var \Magento\Customer\Api\Data\CustomerInterface $customer
         */
        $customer = $this->_customerSession->getCustomerDataObject();

        return trim($this->_customerViewHelper->getCustomerName($customer));
    }

    /**
     * Get user email
     *
     * @return string
     */
    public function getUserEmail()
    {
        if (!$this->_customerSession->isLoggedIn()) {
            return '';
        }
        /**
         * @var CustomerInterface $customer
         */
        $customer = $this->_customerSession->getCustomerDataObject();

        return $customer->getEmail();
    }    
}