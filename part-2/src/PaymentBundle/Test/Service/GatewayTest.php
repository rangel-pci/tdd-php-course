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
        $logger = $this->createMock(LoggerInterface::class);
        $user = 'test';
        $password = 'valid-password';
        $gateway = new Gateway($httpClient, $logger, $user, $password);

        $map = [
            [
                'POST',
                Gateway::BASE_URL . '/authenticate',
                [
                    'user' => $user,
                    'password' => $password
                ],
                null
            ]
        ];

        $httpClient
            ->expects($this->once())
            ->method('send')
            ->will($this->returnValueMap($map));        

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
        $logger = $this->createMock(LoggerInterface::class);
        $user = 'test';
        $password = 'valid-password';
        $gateway = new Gateway($httpClient, $logger, $user, $password);
        $dateTime = new DateTime('now');

        $name = 'José Luiz Silva';
        $creditCardNumber = 5555444466663333;
        $value = 100;
        $token = 'valid-token';
        
        $map = [
            [
                'POST',
                Gateway::BASE_URL . '/authenticate',
                [
                    'user' =>  $user,
                    'password' => $password
                ],
                'valid-token'
            ],
            [
                'POST',
                Gateway::BASE_URL . '/pay',
                [
                    'name' => $name,
                    'credit_card_number' => $creditCardNumber,
                    'validity' => $dateTime,
                    'value' => $value,
                    'token' => $token
                ],
                ['paid' => false]
            ]
        ];
        $httpClient
            ->expects($this->atLeast(2))
            ->method('send')
            ->will($this->returnValueMap($map));

        $paid = $gateway->pay(
            $name,
            $creditCardNumber,
            $dateTime,
            $value
        );

        $this->assertEquals(false, $paid);
    }

    public function testShouldSuccessWhenGatewayReturnOk(){
        $httpClient = $this->createMock(HttpClientInterface::class);
        $logger = $this->createMock(LoggerInterface::class);
        $user = 'test';
        $password = 'valid-password';
        $gateway = new Gateway($httpClient, $logger, $user, $password);
        $dateTime = new DateTime('now');

        $name = 'José Luiz Silva';
        $creditCardNumber = 9999999999999999;
        $value = 100;
        $token = 'valid-token';
        
        
        $map = [
            [
                'POST',
                Gateway::BASE_URL . '/authenticate',
                [
                    'user' => 'test',
                    'password' => 'valid-password'
                ],
                'valid-token'
            ],
            [
                'POST',
                Gateway::BASE_URL . '/pay',
                [
                    'name' => $name,
                    'credit_card_number' => 9999999999999999,
                    'validity' => $dateTime,
                    'value' => $value,
                    'token' => $token
                ],
                ['paid' => true]
            ]
        ];
        $httpClient
            ->expects($this->atLeast(2))
            ->method('send')
            ->will($this->returnValueMap($map));

        $paid = $gateway->pay(
            $name,
            $creditCardNumber,
            $dateTime,
            $value
        );

        $this->assertEquals(true, $paid);
    }
}