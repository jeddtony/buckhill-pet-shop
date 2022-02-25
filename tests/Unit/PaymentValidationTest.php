<?php

namespace Tests\Unit;

use App\Payment\CashOnDeliveryPayment;
use App\Payment\CreditCardPayment;
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
    public function testCashOnDeliveryValidationCanFail() {

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

          /**
     * Can validate credit card payment.
     *
     * @return void
     */
    public function testCreditCardCanValidateSuccessfully() {

        // create input data
        $input = [
            'holder_name' => 'John Doe',
            'number' => '1234567890123456',
            'cvv' => '123',
            'expiry_date' => '12/20',
        ];
 
         // create validator
         $creditCardPayment = new CreditCardPayment;
         $validator = $creditCardPayment->validate($input);
          
         // assert validation passes
         $this->assertTrue(!$validator->fails());
     }
 
     /**
      * Can validate cash on delivery payment fails.
      *
      * @return void
      */
     public function testCreditCardValidationCanFail() {
 
         // create input data
        $input = [
            'holder_name' => 'John Doe',
            'number' => '1234567890123456',
            'cvv' => '123',
        ];
  
          // create validator
         $creditCardPayment = new CreditCardPayment;
         $validator = $creditCardPayment->validate($input);
          
          // assert validation fails
          $this->assertTrue($validator->fails());
      }

}
