<?php

declare(strict_types=1);

/**
 * MsaQuickpay Gateway.
 */

namespace Omnipay\MsaQuickpay;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\MsaQuickpay\Message\PurchaseRequest;

/**
 * MsaQuickpay Gateway.
 *
 * @method RequestInterface authorize(array $options = []) (Optional method)
 * Authorize an amount on the customers card
 * @method RequestInterface completeAuthorize(array $options = []) (Optional method)
 * Handle return from off-site gateways after authorization
 * @method RequestInterface capture(array $options = []) (Optional method)
 * Capture an amount you have previously authorized
 * @method RequestInterface completePurchase(array $options = []) (Optional method)
 * Handle return from off-site gateways after purchase
 * @method RequestInterface createToken(array $options = []) (Optional method)
 * Tokenize a credit card
 * @method RequestInterface refund(array $options = []) (Optional method)
 * Refund an already processed transaction
 * @method RequestInterface void(array $options = []) (Optional method)
 * Generally can only be called up to 24 hours after submitting a transaction
 * @method RequestInterface createCard(array $options = []) (Optional method)
 * The returned response object includes a cardReference, which can be used for future transactions
 * @method RequestInterface updateCard(array $options = []) (Optional method)
 * Update a stored card
 * @method RequestInterface deleteCard(array $options = []) (Optional method)
 * Delete a stored card
 */
class Gateway extends AbstractGateway
{
    public function getName(): string
    {
        return 'MsaQuickpay';
    }

    /**
     * Get the gateway parameters.
     */
    public function getDefaultParameters(): array
    {
        return [
            'endpointBase' => 'https://quickpay.mystudentaccount.com/api',
            'siteId' => '',
            'entityId' => '',
            'clientId' => '',
            'authKey' => '',
        ];
    }

    public function getEndpointBase(): string
    {
        return $this->getParameter('endpointBase');
    }

    public function setEndpointBase(string $value): self
    {
        return $this->setParameter('endpointBase', $value);
    }

    public function getSiteId(): string
    {
        return $this->getParameter('siteId');
    }

    public function setSiteId(string $value): self
    {
        return $this->setParameter('siteId', $value);
    }

    public function getEntityId(): string
    {
        return $this->getParameter('entityId');
    }

    public function setEntityId(string $value): self
    {
        return $this->setParameter('entityId', $value);
    }

    public function getClientId(): string
    {
        return $this->getParameter('clientId');
    }

    public function setClientId(string $value): self
    {
        return $this->setParameter('clientId', $value);
    }

    public function getAuthKey(): string
    {
        return $this->getParameter('authKey');
    }

    public function setAuthKey(string $value): self
    {
        return $this->setParameter('authKey', $value);
    }

    /**
     * Purchase request.
     */
    public function purchase(array $options = []): AbstractRequest
    {
        return $this->createRequest(PurchaseRequest::class, $options);
    }
}
