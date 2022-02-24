<?php

namespace App\Payment;
use Illuminate\Support\Facades\Validator;

class CashOnDeliveryPayment implements Payment
{
    public function validate(array $details)
    {
        
        $validator = Validator::make($details, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'address_one' => 'required|string',
            'address_two' => 'required|string',
            'does_consent_to_condition' => 'required|boolean',
        ]);

        return $validator;
    }
}