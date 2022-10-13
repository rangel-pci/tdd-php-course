<?php

namespace OrderBundle\Validators\Test;

use DateTime;
use OrderBundle\Validators\CreditCardExpirationValidator;
use PHPUnit\Framework\TestCase;

class CreditCardExpirationValidatorTest extends TestCase {
     
    /**
     * @dataProvider valueProvider
     */
    public function testIsValid($value, $expectedResult){
        $creditCardExpirationDate = new DateTime($value);
        $creditCardExpirationValidator = new CreditCardExpirationValidator($creditCardExpirationDate);
        $isValid = $creditCardExpirationValidator->isValid();
        $this->assertEquals($expectedResult, $isValid);
    }

    public function valueProvider(){
        return [
            'testShouldBeValidWhenDateIsNotExpired' => ['value' => '2040-01-01', 'expectedResult' => true],
            'testShouldNotBeValidWhenDateIsExpired' => ['value' => '2005-01-01', 'expectedResult' => false],
        ];
    }
}