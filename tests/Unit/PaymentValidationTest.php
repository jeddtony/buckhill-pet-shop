<?php

namespace Tests\Unit;

use App\Payment\CashOnDeliveryPayment;
use Tests\TestCase;

class PaymentValidationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }


     /**
     * Can validate cash on delivery payment.
     *
     * @return void
     */
    public function testCashOnDeliveryCanValidateSuccessfully() {

       // create input data
         $input = [
              'first_name' => 'John',
              'last_name' => 'Doe',
              'address_one' => '123 Main St',
              'address_two' => 'Apt. 1',
              'does_consent_to_condition' => true,
         ];

        // create validator
        $cashOnDelivery = new CashOnDeliveryPayment;
        $validator = $cashOnDelivery->validate($input);
         
        // assert validation passes
        $this->assertTrue(!$validator->fails());
    }

    /**
     * Can validate cash on delivery payment fails.
     *
     * @return void
     */
    public function testCashOnDeliveryCanValidateCanFail() {

        // create input data
          $input = [
               'first_name' => 'John',
               'last_name' => 'Doe',
               'address_one' => '123 Main St',
               'address_two' => 'Apt. 1'
          ];
 
         // create validator
         $cashOnDelivery = new CashOnDeliveryPayment;
         $validator = $cashOnDelivery->validate($input);
          
         // assert validation fails
         $this->assertTrue($validator->fails());
     }
}
