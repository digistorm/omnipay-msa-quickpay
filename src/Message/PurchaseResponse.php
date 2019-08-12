<?php

namespace Omnipay\MsaQuickpay\Message;

class PurchaseResponse extends AbstractResponse
{
    /**
     * Gateway Reference
     *
     * @return null|string A reference provided by the gateway to represent this transaction
     */
    public function getTransactionReference()
    {
        if (isset($this->data['ReceiptNumber'])) {
            return $this->data['ReceiptNumber'];
        }
    }

    /**
     * Get the transaction ID as generated by the merchant website.
     *
     * @return string
     */
    public function getTransactionId()
    {
        return null;
    }
}