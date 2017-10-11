<?php

namespace Parks\Dealer\Controller\Details;

class Index extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {

      	$resultPage = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_PAGE);      	

	    $resultPage->getConfig()->getTitle()->set(__('Dealer Details'));	    

        return $resultPage;
    }
}