<?php

namespace App\Payment;
use Illuminate\Support\Facades\Validator;

class CreditCardPayment implements Payment
{
    public function validate($details)
    {
        $validator = Validator::make($details, [
            'holder_name' => 'required|string',
            'number' => 'required',
            'cvv' => 'required|numeric',
            'expiry_date' => 'required|string',
        ]);

        return $validator;
    }
}