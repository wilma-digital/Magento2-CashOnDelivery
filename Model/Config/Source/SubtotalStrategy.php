<?php
/**
 * Phoenix Cash on Delivery module for Magento 2
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Mage
 * @package    Phoenix_CashOnDelivery
 * @copyright  Copyright (c) 2017 Phoenix Media GmbH (http://www.phoenix-media.eu)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Phoenix\CashOnDelivery\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;
use Phoenix\CashOnDelivery\Model\Config;

class SubtotalStrategy implements ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['label' => __('Default'), 'value' => Config::SUBTOTAL_STRATEGY_DEFAULT],
            ['label' => __('Including Taxes'), 'value' => Config::SUBTOTAL_STRATEGY_INCL_TAX],
            ['label' => __('Excluding Taxes'), 'value' => Config::SUBTOTAL_STRATEGY_EXCL_TAX]
        ];
    }
}
