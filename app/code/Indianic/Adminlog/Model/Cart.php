<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Indianic\Adminlog\Model;

class Cart extends \Magento\Checkout\Model\Cart
{
    public function updateItems($data)
    {
        $infoDataObject = new \Magento\Framework\DataObject($data);
        $this->_eventManager->dispatch(
            'checkout_cart_update_items_before',
            ['cart' => $this, 'info' => $infoDataObject]
        );


        $qtyRecalculatedFlag = false;
        foreach ($data as $itemId => $itemInfo) {
            $item = $this->getQuote()->getItemById($itemId);
            if (!$item) {
                continue;
            }

            if (!empty($itemInfo['remove']) || isset($itemInfo['qty']) && $itemInfo['qty'] == '0') {
                $this->removeItem($itemId);
                continue;
            }

            $qty = isset($itemInfo['qty']) ? (double)$itemInfo['qty'] : false;
            $remark = isset($itemInfo['remark']) ? $itemInfo['remark'] : false;
            if ($qty > 0) {
                $item->setQty($qty);
                $item->setRemark($remark);

                if ($item->getHasError()) {
                    throw new \Magento\Framework\Exception\LocalizedException(__($item->getMessage()));
                }

                if (isset($itemInfo['before_suggest_qty']) && $itemInfo['before_suggest_qty'] != $qty) {
                    $qtyRecalculatedFlag = true;
                    $this->messageManager->addNotice(
                        __('Quantity was recalculated from %1 to %2', $itemInfo['before_suggest_qty'], $qty),
                        'quote_item' . $item->getId()
                    );
                }
            }
        }

        if ($qtyRecalculatedFlag) {
            $this->messageManager->addNotice(
                __('We adjusted product quantities to fit the required increments.')
            );
        }

        $this->_eventManager->dispatch(
            'checkout_cart_update_items_after',
            ['cart' => $this, 'info' => $infoDataObject]
        );

        return $this;
    }
}
