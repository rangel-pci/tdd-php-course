<?php

namespace OrderBundle\Validators\Test;

use OrderBundle\Validators\NotEmptyValidator;
use PHPUnit\Framework\TestCase;

class NotEmptyValidatorTest extends TestCase {

    // public function testShouldNotBeValidWhenValueIsEmpty(){
    //     $emptyValue = '';
    //     $notEmptyValidator = new NotEmptyValidator($emptyValue);

    //     $isValid = $notEmptyValidator->isValid();
    //     $this->assertFalse($isValid);
    // }

    // public function testShouldNotBeValidWhenValueIsNotEmpty(){
    //     $notEmptyValue = 'filled';
    //     $notEmptyValidator = new NotEmptyValidator($notEmptyValue);

    //     $isValid = $notEmptyValidator->isValid();
    //     $this->assertTrue($isValid);
    // }
    
    /**
     * @dataProvider valueProvider
     */
    public function testIsValid($value, $expectedResult){
        $notEmptyValidator = new NotEmptyValidator($value);
        $isValid = $notEmptyValidator->isValid();
        $this->assertEquals($expectedResult, $isValid);
    }

    public function valueProvider(){
        return [
            'testShouldBeValidWhenValueIsNotEmpty' => ['value' => 'foo', 'expectedResult' => true],
            'testShouldBeValidWhenValueIsEmpty' => ['value' => '', 'expectedResult' => false],
        ];
    }
}