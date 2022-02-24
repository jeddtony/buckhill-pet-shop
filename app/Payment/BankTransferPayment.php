<?php

namespace App\Payment;
use Illuminate\Support\Facades\Validator;

class BankTransferPayment implements Payment
{
    public function validate($details)
    {
        $validator = Validator::make($details, [
            'swift' => 'required|string',
            'iban' => 'required|string',
            'name' => 'required|string',
            'ref_code' => 'required|string'
        ]);

        return $validator;
    }
}