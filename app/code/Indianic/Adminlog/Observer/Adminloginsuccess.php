<?php

namespace Indianic\Adminlog\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class AdminloginSuccess implements ObserverInterface {
	
	protected $_objectManager;
	public function execute(\Magento\Framework\Event\Observer $observer){
		
		$this->_objectManager =  \Magento\Framework\App\ObjectManager::getInstance();

		$model = $this->_objectManager->create('Indianic\Adminlog\Model\Adminlog');
		
		$obj = $this->_objectManager->get('Magento\Framework\HTTP\PhpEnvironment\RemoteAddress');	
	   	
	   	$user = $observer->getEvent()->getUser();
	   	if($user->getIpAddress() != $obj->getRemoteAddress() )
	   	{
	   		echo "Please Contact Adminstator. you have logedin from wrong Ip address. Please login With this ip address ".$user->getIpAddress();die;	   		
	   	}
	   	
	    $model->setName($user->getUserName())->setIp($obj->getRemoteAddress())->setLoginTime(date('Y-m-d h:i:s'))->setStatus("LogedIn Successfull")->save();

    }

}