<?php

namespace Indianic\Adminlog\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class AdminlogoutSuccess implements ObserverInterface {
	
	protected $_objectManager;

	public function execute(\Magento\Framework\Event\Observer $observer){
		
		
		$this->_objectManager =  \Magento\Framework\App\ObjectManager::getInstance();
		$model = $this->_objectManager->create('Indianic\Adminlog\Model\Adminlog');
		$obj = $this->_objectManager->get('Magento\Framework\HTTP\PhpEnvironment\RemoteAddress');	
	   	$user = $observer->getEvent()->getUser();
	   	$model->setName($user->getUser()->getData('username'))->setIp($obj->getRemoteAddress())->setLoginTime(date('Y-m-d h:i:s'))->setStatus("LogedOut Successfull")->save();

    }

}