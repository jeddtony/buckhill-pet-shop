<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Uuid\CustomUuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Create a new payment.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:credit_card,cash_on_delivery,bank_transfer',
            'details' => 'required|array',
        ]);

        if ($validator->fails()) {
            return $this->formatInputErrorResponse($validator->errors()->first());
        }

        // Make specific validation for each payment type
        $paymentType = $request->type;
        $class = "App\\Payment\\" . Str::studly($paymentType) . "Payment";

        $payment = new $class;

        $validatedPayment = $payment->validate($request->details);

        if($validatedPayment->fails()) {
            return $this->formatInputErrorResponse($validatedPayment->errors()->first());
        }
        
        $order = Payment::create([
            'uuid' => CustomUuid::generateUuid('Payment'),
            'type' => $paymentType,
            'details' => json_encode($request->details),
        ]    
        );

        // return success response
        return $this->formatCreatedResponse('Order created successfully', $order);
    }

    /**
     * Get all payments.
     *
     * @return Response
     */
    public function index()
    {
        $payments = Payment::all();

        return $this->formatSuccessResponse('Payments retrieved successfully', $payments);
    }

    /**
     * Get a payment.
     *
     * @param  string  $uuid
     * @return Response
     */
    public function show($uuid)
    {
        $payment = Payment::where('uuid', $uuid)->first();

        if (!$payment) {
            return $this->formatNotFoundResponse('Payment not found');
        }

        return $this->formatSuccessResponse('Payment retrieved successfully', $payment);
    }

   }
