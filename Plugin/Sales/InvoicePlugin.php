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

namespace Phoenix\CashOnDelivery\Plugin\Sales;

use Magento\Sales\Model\Order\Invoice;
use Phoenix\CashOnDelivery\Model\Config;

/**
 * Class InvoicePlugin
 *
 * @package Phoenix\CashOnDelivery\Plugin\Sales
 */
class InvoicePlugin
{
    private $codConfig;
    public function __construct(
        Config $codConfig
    ) {
        $this->codConfig = $codConfig;
    }

    /**
     * Adds invoiced Cash on Delivery fee and tax to order
     *
     * @param Invoice $subject
     * @param Invoice $invoice
     * @return Invoice
     */
    public function afterRegister(
        Invoice $subject,
        Invoice $invoice
    ) {
        $order = $subject->getOrder();

        if($this->codConfig->codFeeIncludesTax()){
            $order->setBaseCodFeeInvoiced($order->getBaseCodFeeInvoiced() + $subject->getBaseCodFeeInclTax());
            $order->setCodFeeInvoiced($order->getCodFeeInvoiced() + $subject->getCodFeeInclTax());
        } else {
            $order->setBaseCodFeeInvoiced($order->getBaseCodFeeInvoiced() + $subject->getBaseCodFee());
            $order->setCodFeeInvoiced($order->getCodFeeInvoiced() + $subject->getCodFee());
        }

        $order->setBaseCodTaxAmountInvoiced($order->getBaseCodTaxAmountInvoiced() + $subject->getBaseCodTaxAmount());
        $order->setCodTaxAmountInvoiced($order->getCodTaxAmountInvoiced() + $subject->getCodTaxAmount());

        return $invoice;
    }

    /**
     * Subtracts Cash on Delivery fee and tax from order
     *
     * @param Invoice $subject
     * @param Invoice $invoice
     * @return Invoice
     */
    public function afterCancel(
        Invoice $subject,
        Invoice $invoice
    ) {
        $order = $subject->getOrder();

        if($this->codConfig->codFeeIncludesTax()){
            $order->setBaseCodFeeInvoiced($order->getBaseCodFeeInvoiced() - $subject->getBaseCodFeeInclTax());
            $order->setCodFeeInvoiced($order->getCodFeeInvoiced() - $subject->getCodFeeInclTax());
        } else {
            $order->setBaseCodFeeInvoiced($order->getBaseCodFeeInvoiced() - $subject->getBaseCodFee());
            $order->setCodFeeInvoiced($order->getCodFeeInvoiced() - $subject->getCodFee());
        }

        $order->setBaseCodTaxAmountInvoiced($order->getBaseCodTaxAmountInvoiced() - $subject->getBaseCodTaxAmount());
        $order->setCodTaxAmountInvoiced($order->getCodTaxAmountInvoiced() - $subject->getCodTaxAmount());

        return $invoice;
    }
}