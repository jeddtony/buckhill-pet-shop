<?php

namespace Tests\Feature;

use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\AuthenticatedTestCase;


class PaymentTest extends AuthenticatedTestCase
{
    use RefreshDatabase;

     /**
     * Test that a user can fetch payments
     *
     * @return void
     */
    public function testUserCanFetchPayments()
    {

        $response = $this->get('api/v1/payments');

        $response->assertStatus(200);
    }

    /**
     * Test that a user can create a payment
     *
     * @return void
     */
    public function testUserCanCreatePayment()
    {

        $response = $this->post('api/v1/payments/create', [
            'type' => 'bank_transfer',
            'details' => [
                'swift' => '100',
                'iban' => 'USD',
                'name' => 'Test payment',
                'ref_code' => 'dummy_ref_code'
            ]
        ]);

        $response->assertStatus(201);
    }

    /**
     * Test that a user can update a payment
     *
     * @return void
     */
    public function testUserCanUpdatePayment() {

        // create a payment;
        $payment = Payment::create([
            'type' => 'bank_transfer',
            'details' => json_encode([
                'swift' => '100',
                'iban' => 'USD',
                'name' => 'Test payment',
                'ref_code' => 'dummy_ref_code'
            ]),
            'uuid' => 'dummy_uuid',
        ]);

        $response = $this->put('api/v1/payments/'.$payment->uuid, [
            'type' => 'bank_transfer',
            'details' => [
                'swift' => '100',
                'iban' => 'USD',
                'name' => 'Test payment',
                'ref_code' => 'dummy_ref_code'
            ]
        ]);

        $response->assertStatus(200);
    }
}
