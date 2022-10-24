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

define(
    [
        'Phoenix_CashOnDelivery/js/view/checkout/summary/cashondelivery',
        'Magento_Checkout/js/model/totals'
    ], function (Component, totals) {
        'use strict';
        
        return Component.extend({
            
             isSelected: function () {
                 if (totals.getSegment('cashondelivery').value > 0 || totals.getSegment('cashondelivery_incl_tax').value > 0) {
                    return true;
                }

                return false;
            },
            
            isDisplayed: function () {
                return true;
            }
        });
    }
);
