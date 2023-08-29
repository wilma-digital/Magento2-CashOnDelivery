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

namespace Phoenix\CashOnDelivery\Model;

use Phoenix\CashOnDelivery\Model\Ui\ConfigProvider;

class CashOnDelivery extends \Magento\Payment\Model\Method\AbstractMethod
{
    protected $_code = ConfigProvider::CODE;

    protected $_formBlockType = 'Phoenix\CashOnDelivery\Block\Form';

    protected $_infoBlockType = 'Phoenix\CashOnDelivery\Block\Info';

    protected $_isOffline = true;

    protected $_canAuthorize = true;

    protected $_canCapture = true;

    protected $_canCapturePartial = true;

    public function getCustomText()
    {
        $customText = $this->getConfigData('customtext');

        return $customText;
    }

    /**
     * {@inheritdoc}
     */
    public function isAvailable(\Magento\Quote\Api\Data\CartInterface $quote = null)
    {
        $available = parent::isAvailable($quote) && $this->isCountryAllowed($quote);

        $disallowSpecificShippingMethods = $this->disallowSpecificShippingMethods();

        if (!$disallowSpecificShippingMethods) {
            return $available;
        }

        $extensionAttributes = $quote->getExtensionAttributes();
        if ($extensionAttributes !== null) {
            $shippingMethods = $extensionAttributes->getShippingAssignments();
            if ($shippingMethods != null) {
                $disallowedShippingMethods = $this->getDisallowedShippingMethods();
                foreach ($shippingMethods as $shippingMethod) {
                    if (in_array($shippingMethod->getShipping()->getMethod(), $disallowedShippingMethods)) {
                        $available = false;
                    }
                    $shippingMethod->getShipping()->getMethod();
                }
            }
        }

        return $available;
    }

    private function disallowSpecificShippingMethods()
    {
        return $this->getConfigData('disallowspecificshippingmethods') === '1';

    }

    private function getDisallowedShippingMethods()
    {
        $disallowedShippingMethods = $this->getConfigData('disallowedshippingmethods')?: "";
        return explode(',', $disallowedShippingMethods);
    }

    /**
     * @param $quote
     * @return bool
     */
    protected function isCountryAllowed($quote): bool
    {
        $countryAllowed = true;
        if ($quote && $this->getConfigData('allowspecific')) {
            $specificCountry = $this->getConfigData('specificcountry')?: "";
            $countries = explode(",", $specificCountry);

            if ($this->getConfigData('addresstype') == 'shipping') {
                $shippingAddress = $quote->getShippingAddress();
            } else {
                $shippingAddress = $quote->getBillingAddress();
            }
            if ($shippingAddress) {
                $countryId = $shippingAddress->getCountryId();
                if ($countryId && !in_array($countryId, $countries)) {
                    $countryAllowed = false;
                }
            }
        }
        return $countryAllowed;
    }

}
