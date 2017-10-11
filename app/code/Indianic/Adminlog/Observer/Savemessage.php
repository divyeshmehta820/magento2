<?php

namespace Indianic\Adminlog\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class Savemessage implements ObserverInterface {
	
	protected $_objectManager;
	public function execute(\Magento\Framework\Event\Observer $observer){
		$order = $observer->getEvent()->getOrder();
		$order->setMessage($observer->getEvent()->getQuote()->getMessage());
		$order->save();
	}

}