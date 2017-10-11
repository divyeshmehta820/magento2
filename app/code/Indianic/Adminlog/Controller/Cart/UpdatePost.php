<?php
/**
 *
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Indianic\Adminlog\Controller\Cart;

class UpdatePost extends \Magento\Checkout\Controller\Cart\UpdatePost
{

    /**
     * Empty customer's shopping cart
     *
     * @return void
     */
    

    /**
     * Update customer's shopping cart
     *
     * @return void
     */
    protected function _updateShoppingCart()
    {
        try {
            $cartData = $this->getRequest()->getParam('cart');
            if (is_array($cartData)) {
                $filter = new \Zend_Filter_LocalizedToNormalized(
                    ['locale' => $this->_objectManager->get('Magento\Framework\Locale\ResolverInterface')->getLocale()]
                );
                foreach ($cartData as $index => $data) {
                    if (isset($data['qty'])) {
                        $cartData[$index]['qty'] = $filter->filter(trim($data['qty']));
                    }

                    if (isset($data['remark'])) {
                        $cartData[$index]['remark'] = trim($data['remark']);
                        $this->messageManager->addSuccess(__('Remark Update Success fully'));
                    }

                }
                if (!$this->cart->getCustomerSession()->getCustomerId() && $this->cart->getQuote()->getCustomerId()) {
                    $this->cart->getQuote()->setCustomerId(null);
                }

                $cartData = $this->cart->suggestItemsQty($cartData);
                $this->cart->updateItems($cartData)->save();
            }
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addError(
                $this->_objectManager->get('Magento\Framework\Escaper')->escapeHtml($e->getMessage())
            );
        } catch (\Exception $e) {
            $this->messageManager->addException($e, __('We can\'t update the shopping cart.'));
            $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
        }
    }

    /**
     * Update shopping cart data action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
   

}
