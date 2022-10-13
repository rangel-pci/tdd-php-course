<?php

namespace PaymentBundle\Test\Service;

use DateTime;
use MyFramework\HttpClientInterface;
use MyFramework\LoggerInterface;
use PaymentBundle\Service\Gateway;
use PHPUnit\Framework\TestCase;

class GateWayTest extends TestCase{
    
    public function testShouldNotPayWhenAuthenticationFail(){
        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->method('send')->will($this->returnCallback(
            function($method, $address, $body){
                return $this->fakeHttpClientSend($method, $address, $body);
            }
        ));
        $logger = $this->createMock(LoggerInterface::class);
        
        $user = 'test';
        $password = 'invalid-password';
        $gateway = new Gateway($httpClient, $logger, $user, $password);

        $paid = $gateway->pay(
            'José Luiz Silva',
            5555444466663333,
            new DateTime('now'),
            100
        );

        $this->assertEquals(false, $paid);
    }

    public function testShouldNotPayWhenFailOnGateway(){
        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->method('send')->will($this->returnCallback(
            function($method, $address, $body){
                return $this->fakeHttpClientSend($method, $address, $body);
            }
        ));
        $logger = $this->createMock(LoggerInterface::class);
        
        $user = 'test';
        $password = 'valid-password';
        $gateway = new Gateway($httpClient, $logger, $user, $password);

        $paid = $gateway->pay(
            'José Luiz Silva',
            5555444466663333,
            new DateTime('now'),
            100
        );

        $this->assertEquals(false, $paid);
    }

    public function testShouldSuccessWhenGatewayReturnOk(){
        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->method('send')->will($this->returnCallback(
            function($method, $address, $body){
                return $this->fakeHttpClientSend($method, $address, $body);
            }
        ));
        $logger = $this->createMock(LoggerInterface::class);
        
        $user = 'test';
        $password = 'valid-password';
        $gateway = new Gateway($httpClient, $logger, $user, $password);

        $paid = $gateway->pay(
            'José Luiz Silva',
            9999999999999999,
            new DateTime('now'),
            100,
        );

        $this->assertEquals(true, $paid);
    }

    public function fakeHttpClientSend($method, $address, $body){
        switch($address){
            case Gateway::BASE_URL . '/authenticate':
                if($body['password'] != 'valid-password'){
                    return null;
                }

                return 'valid-token';
                break;
            case Gateway::BASE_URL . '/pay':

                if($body['credit_card_number'] == 9999999999999999){
                    return ['paid' => true];
                }

                return ['paid' => false];
                break;
        }
    }
}