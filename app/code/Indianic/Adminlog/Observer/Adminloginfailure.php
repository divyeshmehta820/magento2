<?php

namespace Indianic\Adminlog\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class Adminloginfailure implements ObserverInterface {
	
	protected $_objectManager;
	public function execute(\Magento\Framework\Event\Observer $observer){
		
		$this->_objectManager =  \Magento\Framework\App\ObjectManager::getInstance();

		$model = $this->_objectManager->create('Indianic\Adminlog\Model\Adminlog');
		
		$obj = $this->_objectManager->get('Magento\Framework\HTTP\PhpEnvironment\RemoteAddress');	
	   	
	   	$user = $observer->getUserName();
	   	$model->setName($user)->setIp($obj->getRemoteAddress())->setStatus("LogedIn Un-Successfull")->setLoginTime(date('Y-m-d h:i:s'))->save();

    }

}