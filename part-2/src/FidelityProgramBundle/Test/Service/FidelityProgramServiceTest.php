<?php

namespace FidelityProgramBundle\Test\Service;

use FidelityProgramBundle\Repository\PointsRepository;
use FidelityProgramBundle\Service\FidelityProgramService;
use FidelityProgramBundle\Service\PointsCalculator;
use MyFramework\LoggerInterface;
use OrderBundle\Entity\Customer;
use PHPUnit\Framework\TestCase;

class FidelityProgramServiceTest extends TestCase {

    public function testShouldSaveWhenReceivePoints(){
        // Mock
        $pointsRepository = $this->createMock(PointsRepository::class);
        // Expects the save method to be called at least once
        $pointsRepository->expects($this->once())->method('save');

        // Stub
        $pointsCalculator = $this->createMock(PointsCalculator::class);
        $pointsCalculator->method('calculatePointsToReceive')->willReturn(100);

        $allMessages = [];
        $logger = $this->createMock(LoggerInterface::class);
        $logger->method('log')->will($this->returnCallback(
            function ($message) use (&$allMessages){
                $allMessages[] = $message;
            }
        ));

        $fidelityProgramService = new FidelityProgramService($pointsRepository, $pointsCalculator, $logger);

        $customer = new Customer(true, false, 'aa');
        $value = 50;
        $fidelityProgramService->addPoints($customer, $value);

        $expectedMessages = [
            'Checking points for customer',
            'Customer received points'
        ];
        $this->assertEquals($expectedMessages, $allMessages);
    }

    public function testShouldNotSaveWhenReceiveZeroPoints(){
        // Mock
        $pointsRepository = $this->createMock(PointsRepository::class);
        // Expects that the save method to be called at least once
        $pointsRepository->expects($this->never())->method('save');

        // Stub
        $pointsCalculator = $this->createMock(PointsCalculator::class);
        $pointsCalculator->method('calculatePointsToReceive')->willReturn(0);

        $logger = $this->createMock(LoggerInterface::class);

        $fidelityProgramService = new FidelityProgramService($pointsRepository, $pointsCalculator, $logger);

        $customer = new Customer(true, false, 'aa');
        $value = 20;

        $fidelityProgramService->addPoints($customer, $value);
    }
}