<?php

namespace OrderBundle\Validators\Test;

use OrderBundle\Validators\NumericValidator;
use PHPUnit\Framework\TestCase;

class NumericValidatorTest extends TestCase {
    
    /**
     * @dataProvider valueProvider
     */
    public function testIsValid($value, $expectedResult){
        $numericValidator = new NumericValidator($value);
        $isValid = $numericValidator->isValid();
        $this->assertEquals($expectedResult, $isValid);
    }

    public function valueProvider(){
        return [
            'testShouldBeValidWhenValueIsANumber' => ['value' => 20, 'expectedResult' => true],
            'testShouldBeValidWhenValueIsANumericString' => ['value' => '20', 'expectedResult' => true],
            'testShouldNotBeValidWhenValueIsNotANumber' => ['value' => 'a', 'expectedResult' => false],
            'testShouldNotBeValidWhenValueIsEmpty' => ['value' => '', 'expectedResult' => false]
        ];
    }
}