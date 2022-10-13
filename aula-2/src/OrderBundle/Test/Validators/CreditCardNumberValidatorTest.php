<?php

namespace OrderBundle\Validators\Test;

use OrderBundle\Validators\CreditCardNumberValidator;
use PHPUnit\Framework\TestCase;

class CreditCardNumberValidatorTest extends TestCase {
    
    /**
     * @dataProvider valueProvider
     */
    public function testIsValid($value, $expectedResult){
        $creditCardNumberValidator = new CreditCardNumberValidator($value);
        $isValid = $creditCardNumberValidator->isValid();
        $this->assertEquals($expectedResult, $isValid);
    }

    public function valueProvider(){
        return [
            'testShouldBeValidWhenValueIsACreditCard' => ['value' => 2032203220322032, 'expectedResult' => true],
            'testShouldBeValidWhenValueIsACreditCardAsString' => ['value' => '2032203220322032', 'expectedResult' => true],
            'testShouldNotBeValidWhenValueIsNotACreditCard' => ['value' => 123, 'expectedResult' => false],
            'testShouldNotBeValidWhenValueIsEmpty' => ['value' => '', 'expectedResult' => false]
        ];
    }
}