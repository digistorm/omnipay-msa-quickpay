<?php

namespace Omnipay\MsaQuickpay\Message;

/**
 * MsaQuickpay Abstract Request.
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * Live or Test Endpoint URL.
     */
    public function getEndpointBase()
    {
        return $this->getParameter('endpointBase');
    }

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
     * @return AbstractRequest
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
     * @return AbstractRequest
     */
    public function setEntityId($value)
    {
        return $this->setParameter('entityId', $value);
    }

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->getParameter('clientId');
    }

    /**
     * @param $value
     *
     * @return AbstractRequest
     */
    public function setClientId($value)
    {
        return $this->setParameter('clientId', $value);
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
     * @return AbstractRequest
     */
    public function setAuthKey($value)
    {
        return $this->setParameter('authKey', $value);
    }

    abstract protected function getEndpoint();

    abstract protected function createResponse($data);

    /**
     * Get HTTP Method.
     *
     * This is nearly always POST but can be over-ridden in sub classes.
     *
     * @return string
     */
    public function getHttpMethod()
    {
        return 'POST';
    }

    /**
     * {@inheritdoc}
     */
    public function sendData($data)
    {
        $headers = [
            'Content-Type' => 'application/json; charset=utf-8',
        ];
        $body = json_encode($data);
        $httpResponse = $this->httpClient->request($this->getHttpMethod(), $this->getEndpoint(), $headers, $body);

        return $this->createResponse(json_decode($httpResponse->getBody()->getContents(), true));
    }
}
