<?php

namespace Phoenix\CashOnDelivery\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Phoenix\CashOnDelivery\Helper\Data;

class RemoveCodInCart implements ObserverInterface
{
    /** @var Data $helper */
    protected $helper;

    /** @var \Magento\Checkout\Model\Session $helper */
    protected $checkoutSession;

    public function __construct (
        Data $helper,
        \Magento\Checkout\Model\Session $checkoutSession
    ) {
        $this->helper = $helper;
        $this->checkoutSession = $checkoutSession;
    }

    public function execute(Observer $observer)
    {
        $quote = $this->checkoutSession->getQuote();
        if (!$quote || !$this->helper->isActiveMethod($quote)) {
            return;
        }

        $quote->getPayment()
            ->setMethod(null)
            ->save();
    }
}
