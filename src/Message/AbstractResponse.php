<?php

declare(strict_types=1);

namespace Omnipay\MsaQuickpay\Message;

/**
 * MsaQuickpay Response.
 *
 * This is the response class for all MsaQuickpay requests.
 *
 * @see \Omnipay\MsaQuickpay\Gateway
 */
abstract class AbstractResponse extends \Omnipay\Common\Message\AbstractResponse
{
    /**
     * Is the transaction successful?
     */
    public function isSuccessful(): bool
    {
        if (!isset($this->data['ResultCode'])) {
            return false;
        }

        return $this->data['ResultCode'] == 0;
    }

    /**
     * Get the response/error message from the response.
     *
     * Returns null if the request was successful.
     */
    public function getMessage(): ?string
    {
        return $this->data['ResultMessage'] ?? null;
    }

    /**
     * Get the response/error code from the response.
     *
     * Returns null if the request was successful.
     */
    public function getCode(): ?string
    {
        return $this->data['ResultCode'] ?? null;
    }
}
