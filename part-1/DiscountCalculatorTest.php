<?php

class DiscountCalculatorTest{
    /**
     * should apply discount when value is above the minimum
     */
    public function shouldApplyDiscountTest(){
        $discountCalculator = new DiscountCalculator();
        $value = 100;
        $expectedValue = 100;
        $total = $discountCalculator->apply($value);
        
        $this->assertEquals($expectedValue, $total);
    }

    /**
     * should not apply discount when value is bellow the minimum
     */
    public function shouldNotApplyDiscountTest(){
        $discountCalculator = new DiscountCalculator();
        $value = 90;
        $expectedValue = 90;
        $total = $discountCalculator->apply($value);
        
        $this->assertEquals($expectedValue, $total);
    }

    public function assertEquals($expectedValue, $actualValue){
        if($expectedValue !== $actualValue){
            $message = 'Expected: ' . $expectedValue . ' but got: ' . $actualValue;
            throw new \Exception($message);
        }

        echo "Test passed! \n";
    }
}