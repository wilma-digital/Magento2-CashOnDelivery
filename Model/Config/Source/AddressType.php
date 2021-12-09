<?php

namespace Phoenix\CashOnDelivery\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;
use Phoenix\CashOnDelivery\Model\Config;

class AddressType implements ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['label' => __('Billing'), 'value' => 'billing'],
            ['label' => __('Shipping'), 'value' => 'shipping'],
        ];
    }
}
