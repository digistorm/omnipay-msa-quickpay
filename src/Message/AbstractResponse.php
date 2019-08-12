<?php

namespace Omnipay\MsaQuickpay\Message;

use Omnipay\Common\Message\RequestInterface;

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
     *
     * @return bool
     */
    public function isSuccessful()
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
     *
     * @return string|null
     */
    public function getMessage()
    {
        if (isset($this->data['ResultMessage'])) {
            return $this->data['ResultMessage'];
        }

        return null;
    }

    /**
     * Get the response/error code from the response.
     *
     * Returns null if the request was successful.
     *
     * @return string|null
     */
    public function getCode()
    {
        if (isset($this->data['ResultCode'])) {
            return $this->data['ResultCode'];
        }

        return null;
    }
}
