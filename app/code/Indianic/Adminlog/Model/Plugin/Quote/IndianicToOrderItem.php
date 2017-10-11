<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Indianic\Adminlog\Model\Plugin\Quote;

use Magento\Framework\DataObject\Copy;
use Magento\Quote\Model\Quote\Item;
use Magento\Quote\Model\Quote\Address\Item as AddressItem;
use Magento\Sales\Api\Data\OrderItemInterfaceFactory as OrderItemFactory;
use Magento\Sales\Api\Data\OrderItemInterface;

/**
 * Class ToOrderItem
 */
class IndianicToOrderItem
{
    
    public function aroundConvert(
        \Magento\Quote\Model\Quote\Item\ToOrderItem $subject,
        \Closure $proceed,
        \Magento\Quote\Model\Quote\Item\AbstractItem $item,
        $additional = []
    ) {

        /** @var $orderItem Item */
        $orderItem = $proceed($item, $additional);
        $orderItem->setRemark($item->getRemark());
        return $orderItem;
    }
}
