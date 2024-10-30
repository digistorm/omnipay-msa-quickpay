<?php

declare(strict_types=1);

namespace Tests\Unit\Message;

use Omnipay\Common\CreditCard;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Http\Client;
use Omnipay\MsaQuickpay\Message\PurchaseRequest;
use Omnipay\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request;

class PurchaseRequestTest extends TestCase
{
    protected PurchaseRequest $request;

    public function setUp(): void
    {
        parent::setUp();
        $httpClient = $this->createMock(Client::class);
        $httpRequest = $this->createMock(Request::class);
        $this->request = $this->getMockForAbstractClass(
            PurchaseRequest::class,
            [$httpClient, $httpRequest]
        );
    }

    public function testGetDataReturnsCorrectArray(): void
    {
        $card = $this->createMock(CreditCard::class);

        $card->method('validate')->willReturn(true);
        $card->method('getBillingName')->willReturn('John Doe');
        $card->method('getNumber')->willReturn('4111111111111111');
        $card->method('getExpiryDate')->willReturnMap([['m', '12'], ['Y', '2025']]);
        $card->method('getCvv')->willReturn('123');

        $this->request->setAmount('100.00')
            ->setCurrency('USD')
            ->setPaymentIdentifier('123456')
            ->setCard($card)
            ->setSiteId('site123')
            ->setEntityId('entity123')
            ->setClientId('client123')
            ->setAuthKey('authkey123')
            ->setDescription('Test Purchase')
            ->setReceiptTemplateId('template123')
            ->setTestMode(true);

        $expectedData = [
            'SiteID' => 'site123',
            'EntityID' => 'entity123',
            'ClientID' => 'client123',
            'AuthToken' => hash('sha256', 'authkey123123456'),
            'TxnType' => 1,
            'PaymentIdentifier' => '123456',
            'PaymentAmount' => 10000,
            'Description' => 'Test Purchase',
            'CardName' => 'John Doe',
            'CardNumber' => '4111111111111111',
            'CardExpiryMonth' => '12',
            'CardExpiryYear' => '2025',
            'CardCVN' => '123',
            'ReceiptTemplateId' => 'template123',
        ];

        $this->assertEquals($expectedData, $this->request->getData());
    }

    public function testGetDataThrowsExceptionWithoutCard(): void
    {
        $this->expectException(InvalidRequestException::class);
        $this->expectExceptionMessage('You must pass a "card" parameter.');
        $this->request->setAmount('100.00')
            ->setCurrency('USD')
            ->setPaymentIdentifier('123456');

        $this->request->getData();
    }
}
