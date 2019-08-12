<?php

/**
 * MsaQuickpay Gateway.
 */
namespace Omnipay\MsaQuickpay;

use Omnipay\MsaQuickpay\Message\PurchaseRequest;
use Omnipay\MsaQuickpay\Message\CreateTokenRequest;
use Omnipay\Common\AbstractGateway;

/**
 * MsaQuickpay Gateway.
 *Z
 * @method \Omnipay\Common\Message\RequestInterface authorize(array $options = array())         (Optional method)
 *         Authorize an amount on the customers card
 * @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array()) (Optional method)
 *         Handle return from off-site gateways after authorization
 * @method \Omnipay\Common\Message\RequestInterface capture(array $options = array())           (Optional method)
 *         Capture an amount you have previously authorized
 * @method \Omnipay\Common\Message\RequestInterface completePurchase(array $options = array())  (Optional method)
 *         Handle return from off-site gateways after purchase
 * @method \Omnipay\Common\Message\RequestInterface createToken(array $options = array())       (Optional method)
 *         Tokenize a credit card
 * @method \Omnipay\Common\Message\RequestInterface refund(array $options = array())            (Optional method)
 *         Refund an already processed transaction
 * @method \Omnipay\Common\Message\RequestInterface void(array $options = array())              (Optional method)
 *         Generally can only be called up to 24 hours after submitting a transaction
 * @method \Omnipay\Common\Message\RequestInterface createCard(array $options = array())        (Optional method)
 *         The returned response object includes a cardReference, which can be used for future transactions
 * @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = array())        (Optional method)
 *         Update a stored card
 * @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = array())        (Optional method)
 *         Delete a stored card
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'MsaQuickpay';
    }

    /**
     * Get the gateway parameters.
     *
     * @return array
     */
    public function getDefaultParameters()
    {
        return [
            'endpointBase' => 'https://quickpay.mystudentaccount.com/api',
            'siteId' => '',
            'entityId' => '',
            'clientId' => '',
            'authKey' => '',
        ];
    }

    /**
     * @return string
     */
    public function getEndpointBase()
    {
        return $this->getParameter('endpointBase');
    }

    /**
     * @param $value
     *
     * @return \Omnipay\MsaQuickpay\Gateway
     */
    public function setEndpointBase($value)
    {
        return $this->setParameter('endpointBase', $value);
    }

    /**
     * @return string
     */
    public function getSiteId()
    {
        return $this->getParameter('siteId');
    }

    /**
     * @param $value
     *
     * @return \Omnipay\MsaQuickpay\Gateway
     */
    public function setSiteId($value)
    {
        return $this->setParameter('siteId', $value);
    }

    /**
     * @return string
     */
    public function getEntityId()
    {
        return $this->getParameter('entityId');
    }

    /**
     * @param $value
     *
     * @return \Omnipay\MsaQuickpay\Gateway
     */
    public function setEntityId($value)
    {
        return $this->setParameter('entityId', $value);
    }

    /**
     * @return string
     */
    public function getCustomerId()
    {
        return $this->getParameter('customerId');
    }

    /**
     * @param $value
     *
     * @return \Omnipay\MsaQuickpay\Gateway
     */
    public function setCustomerId($value)
    {
        return $this->setParameter('customerId', $value);
    }

    /**
     * @return string
     */
    public function getAuthKey()
    {
        return $this->getParameter('authKey');
    }

    /**
     * @param $value
     *
     * @return \Omnipay\MsaQuickpay\Gateway
     */
    public function setAuthKey($value)
    {
        return $this->setParameter('authKey', $value);
    }

    /**
     * Purchase request.
     *
     * @param array $parameters
     *
     * @return \Omnipay\MsaQuickpay\Message\PurchaseRequest|\Omnipay\Common\Message\AbstractRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }
}
