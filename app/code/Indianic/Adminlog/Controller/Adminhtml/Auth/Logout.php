<?php
/**
 *
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Indianic\Adminlog\Controller\Adminhtml\Auth;

class Logout extends \Magento\Backend\Controller\Adminhtml\Auth\Logout
{
    
    /**
     * Administrator logout action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
     
    public function execute()
    {

        if($this->_auth->isLoggedIn())
        {
            $this->_eventManager->dispatch('backend_auth_user_logout_success', ['user' => $this->_auth]);
        }   
        $this->_auth->logout();
        $this->messageManager->addSuccess(__('You have logged out.'));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath($this->_helper->getHomePageUrl());
    }
}
