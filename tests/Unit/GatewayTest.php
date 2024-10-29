<?php

declare(strict_types=1);

namespace Tests\Unit;

use Omnipay\MsaQuickpay\Gateway;
use Omnipay\MsaQuickpay\Message\PurchaseRequest;
use Omnipay\Tests\TestCase;

class GatewayTest extends TestCase
{
    public function testPurchaseCreatesPurchaseRequest(): void
    {
        $gateway = new Gateway();
        $parameters = [
            'amount' => '100.00',
            'siteId' => '123',
            'entityId' => '456',
            'clientId' => '789',
            'authKey' => 'abc123',
        ];
        $expected = array_merge($gateway->getDefaultParameters(), $parameters);
        $request = $gateway->purchase($parameters);
        $this->assertInstanceOf(PurchaseRequest::class, $request);
        $this->assertEquals($expected, $request->getParameters());
    }
}
