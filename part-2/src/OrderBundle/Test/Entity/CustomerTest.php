<?php

namespace OrderBundle\Entity\Test;

use OrderBundle\Entity\Customer;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase {

    /**
     * @dataProvider customerAllowedDataProvider
     */
    public function testIsAllowedToOrder($isActive, $isBlocked, $expectedAllowed){
        $customer = new Customer($isActive, $isBlocked, 'Rangel', '61999999999');

        $isAllowed = $customer->isAllowedToOrder();
        $this->assertEquals($expectedAllowed, $isAllowed);
    }

    public function customerAllowedDataProvider(){
        return [
            'shouldBeAllowedWhenActiveAndNotBlocked' => ['isActive' => true, 'isBlocked' => false, 'expectedAlowed' => true],
            'shouldNotBeAllowedWhenIsActiveButIsBlocked' => ['isActive' => true, 'isBlocked' => true, 'expectedAlowed' => false],
            'shouldNotBeAllowedWhenIsNotActive' => ['isActive' => false, 'isBlocked' => false, 'expectedAlowed' => false],
            'shouldNotBeAllowedWhenIsNotActiveAndIsBlocked' => ['isActive' => false, 'isBlocked' => true, 'expectedAlowed' => false],
        ];
    }
}