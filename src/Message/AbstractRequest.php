<?php

declare(strict_types=1);

namespace Omnipay\MsaQuickpay\Message;

use Omnipay\Common\Message\ResponseInterface;

/**
 * MsaQuickpay Abstract Request.
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    abstract protected function getEndpoint(): string;

    abstract protected function createResponse(string $data): ResponseInterface;

    /**
     * Live or Test Endpoint URL.
     */
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
     * Get HTTP Method.
     *
     * This is nearly always POST but can be over-ridden in sub classes.
     */
    public function getHttpMethod(): string
    {
        return 'POST';
    }

    /**
     * {@inheritdoc}
     */
    public function sendData(mixed $data): ResponseInterface
    {
        $headers = [
            'Content-Type' => 'application/json; charset=utf-8',
        ];
        $body = json_encode($data);
        $httpResponse = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            $headers,
            $body ?: null,
        );

        return $this->createResponse(json_decode($httpResponse->getBody()->getContents(), true));
    }
}
