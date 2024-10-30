<?php

declare(strict_types=1);

namespace Omnipay\MsaQuickpay\Message;

use Omnipay\Common\Exception\InvalidCreditCardException;
use Omnipay\Common\Exception\InvalidRequestException;

/**
 * MsaQuickpay Purchase Request.
 */
class PurchaseRequest extends AbstractRequest
{
    /**
     * Get request data array to process a purchase.
     * @throws InvalidCreditCardException
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate('amount', 'currency', 'paymentIdentifier');

        if (!$this->getParameter('card')) {
            throw new InvalidRequestException('You must pass a "card" parameter.');
        }

        /* @var $card \OmniPay\Common\CreditCard */
        $card = $this->getParameter('card');
        $card->validate();

        return [
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
            'ReceiptTemplateId' => $this->getReceiptTemplateId(),
        ];
    }

    public function getEndpoint(): string
    {
        return parent::getEndpointBase() . '/payment/process';
    }

    public function getPaymentIdentifier(): string
    {
        return $this->getParameter('paymentIdentifier');
    }

    public function setPaymentIdentifier(string $value): self
    {
        return $this->setParameter('paymentIdentifier', $value);
    }

    public function getReceiptTemplateId(): string
    {
        return $this->getParameter('receiptTemplateId');
    }

    public function setReceiptTemplateId(string $value): self
    {
        return $this->setParameter('receiptTemplateId', $value);
    }

    protected function getAuthToken(): string
    {
        return hash('sha256', $this->getAuthKey() . $this->getPaymentIdentifier());
    }

    protected function createResponse(mixed $data): PurchaseResponse
    {
        return $this->response = new PurchaseResponse($this, $data);
    }
}
