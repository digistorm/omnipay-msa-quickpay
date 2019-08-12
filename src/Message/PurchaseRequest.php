<?php

namespace Omnipay\MsaQuickpay\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * MsaQuickpay Purchase Request.
 */
class PurchaseRequest extends AbstractRequest
{
    /**
     * Get request data array to process a purchase.
     *
     * @return array|mixed
     *
     * @throws \Omnipay\Common\Exception\InvalidCreditCardException
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('amount', 'currency', 'paymentIdentifier');

        if (!$this->getParameter('card')) {
            throw new InvalidRequestException('You must pass a "card" parameter.');
        }

        /* @var $card \OmniPay\Common\CreditCard */
        $card = $this->getParameter('card');
        $card->validate();

        $data = [
            'SiteID' => $this->getSiteId(),
            'EntityID' => $this->getEntityId(),
            'ClientID' => $this->getClientId(),
            'AuthToken' => $this->getAuthToken(),
            'TxnType' => $this->getTestMode() ? 1 : 0,
            'PaymentIdentifier' => $this->getPaymentIdentifier(),
            'PaymentAmount' => $this->getAmountInteger(),
            'Description' => $this->getDescription(),
            'CardName' => $card->getBillingName(),
            'CardNumber' => $card->getNumber(),
            'CardExpiryMonth' => $card->getExpiryDate('m'),
            'CardExpiryYear' => $card->getExpiryDate('Y'),
            'CardCVN' => $card->getCvv(),
        ];

        return $data;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndpointBase() . '/payment/process';
    }

    /**
     * @return integer
     */
    public function getPaymentIdentifier()
    {
        return $this->getParameter('paymentIdentifier');
    }

    /**
     * @param string $value
     *
     * @return \Omnipay\MsaQuickpay\Message\AbstractRequest provides a fluent interface.
     */
    public function setPaymentIdentifier($value)
    {
        return $this->setParameter('paymentIdentifier', $value);
    }

    protected function getAuthToken()
    {
        return hash('sha256', $this->getAuthKey() . $this->getPaymentIdentifier());
    }

    /**
     * @param       $data
     *
     * @return \Omnipay\MsaQuickpay\Message\PurchaseResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }
}
