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

     /**
     * 
     * @OA\Post(
     *      path="/api/v1/payments/create",
     *      operationId="storePayments",
     *      tags={"Payments"},
     *      summary="Store Payments",
     *      description="Returns the created payment",
     *      security={{"passport": {"*"}}},
     *    @OA\RequestBody(
     *        @OA\MediaType( mediaType="application/json",
     *           @OA\Schema(
     *             @OA\Property(property="type", type="string", description="Value must be 'cash_on_delivery', 'bank_transfer', 'credit_card' "),
     *              @OA\Property(property="details", type="array",
     *             @OA\Items(
     *                @OA\Property(property="swift", type="string", description="Swift code"),
     *               @OA\Property(property="iban", type="string", description="IBAN code"),
     *             @OA\Property(property="name", type="string", description="Name of the payment"),
     *            @OA\Property(property="ref_code", type="string", description="Reference code"),
     * )
     *             ),
     * ),
     * ),
     * ),
     *                  
     *      @OA\Response(
     *          response=201,
     *          description="Payment created successfully",
     *         
     *       ),
     *     
     *      @OA\Response(
     *      response=404,
     *      description="Not found"
     *   ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *      )
     *     )
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

     /**
     * 
     *  @OA\Get(
     *      path="/api/v1/payments",
     *      operationId="getPaymentsList",
     *      tags={"Payments"},
     *      summary="Get list of Payments",
     *      description="Returns list of payments",
     *     security={{"passport": {"*"}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       
     *       ),
     *      @OA\Response(
     *      response=404,
     *      description="Not found"
     *   ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *      )
     *     )
     *     )
     */
    

    public function index()
    {
        $payments = Payment::all();

        return $this->formatSuccessResponse('Payments retrieved successfully', $payments);
    }

     /**
     * 
     *  @OA\Get(
     *      path="/api/v1/payments/{uuid}",
     *      operationId="getOnePaymentDetail",
     *      tags={"Payments"},
     *      summary="Get details of a payment",
     *      description="Returns a payment detail",
     *  @OA\Parameter(name="uuid", in="path", description="Uuidd of payment", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *     security={{"passport": {"*"}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       
     *       ),
     *      @OA\Response(
     *      response=404,
     *      description="Not found"
     *   ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *      )
     *     )
     *     )
     *
    
     * Get a payment.
     *
     * @param  string  $uuid
     * @return Response
     */
    public function show($uuid)
    {
        $payment = Payment::where('uuid', $uuid)->first();

        if (!$payment) {
            return $this->notFoundResponse('Payment not found');
        }

        return $this->formatSuccessResponse('Payment retrieved successfully', $payment);
    }

    /**
     *  /**
     * 
     * @OA\Put(
     *      path="/api/v1/payments/{uuid}",
     *      operationId="updatePayments",
     *      tags={"Payments"},
     *      summary="Update a payment",
     *      description="Returns the updated payment",
     *      security={{"passport": {"*"}}},
     * @OA\Parameter(name="uuid", in="path", description="Uuidd of payment", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *    @OA\RequestBody(
     *        @OA\MediaType( mediaType="application/json",
     *           @OA\Schema(
     *             @OA\Property(property="type", type="string", description="Value must be 'cash_on_delivery', 'bank_transfer', 'credit_card' "),
     *              @OA\Property(property="details", type="array",
     *             @OA\Items(
     *                @OA\Property(property="swift", type="string", description="Swift code"),
     *               @OA\Property(property="iban", type="string", description="IBAN code"),
     *             @OA\Property(property="name", type="string", description="Name of the payment"),
     *            @OA\Property(property="ref_code", type="string", description="Reference code"),
     * )
     *             ),
     * ),
     * ),
     * ),
     *                  
     *      @OA\Response(
     *          response=201,
     *          description="Payment created successfully",
     *         
     *       ),
     *     
     *      @OA\Response(
     *      response=404,
     *      description="Not found"
     *   ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *      )
     *     )
     *
     * 
     * Update a payment.
     *
     * @param Request $request
     * @param string $uuid
     * @return Response
     */
    public function update(Request $request, $uuid)
    {
        $payment = Payment::where('uuid', $uuid)->first();

        if (!$payment) {
            return $this->notFoundResponse('Payment not found');
        }

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

        $paymentClass = new $class;

        $validatedPayment = $paymentClass->validate($request->details);

        if($validatedPayment->fails()) {
            return $this->formatInputErrorResponse($validatedPayment->errors()->first());
        }

        $payment->update([
            'type' => $paymentType,
            'details' => json_encode($request->details),
        ]);

        return $this->formatSuccessResponse('Payment updated successfully', $payment);
    }

     /**
     * Remove the payment resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy( $uuid)
    {
        // delete payment
        $payment = Payment::where('uuid', $uuid)->first();

        // delete payment
        $payment->delete();

        // return deleted response
        return $this->formatDeletedResponse('Payment deleted successfully');

    }
}
