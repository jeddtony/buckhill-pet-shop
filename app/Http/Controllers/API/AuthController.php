<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    
    /**
     * @OA\Post(
     *      path="/api/v1/user/create",
     *      tags={"Users"},
     *      summary="Register new user",
     *      operationId="register",
     *      @OA\Parameter(
     *          name="first_name",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="last_name",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="email",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="address",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="password",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="phone_number",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Registration successful"
     *      ),
     *    @OA\Response(
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
     * )
     *
     * Register new user.
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:55',
            'last_name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required',
            'address' => 'required|max:255',
            'phone_number' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return $this->formatInputErrorResponse($validator->errors()->first());
        }
        $validatedData = $request->all();
        $validatedData['password'] = bcrypt($request->password);
        $validatedData['uuid'] = Str::uuid();

        $user = User::create($validatedData);

        
        $access_token = $user->createToken('authToken')->accessToken;
        
        
        $data = [
            'user' => $user,
            'access_token' => $access_token
        ];
        return $this->formatCreatedResponse('Registration successful', $data);
    }

    /** @OA\Post(
    *      path="/api/v1/user/login",
    *      tags={"Users"},
    *      summary="Login user",
    *      operationId="login",
    *      @OA\Parameter(
    *          name="email",
    *          in="query",
    *          @OA\Schema(
    *              type="string"
    *          )
    *      ),
    *      @OA\Parameter(
    *          name="password",
    *          in="query",
    *          @OA\Schema(
    *              type="string"
    *          )
    *      ),
    *     
    *      @OA\Response(
     *          response=200,
     *          description="Login successful"
     *      ),
     *  @OA\Response(
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
     * )
    * Create a new login session for a user.
    *
    * @param  Request  $request
    * @return Response
    */
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email'    => 'required',
            'password' => 'required'
        ]);

        if($validator->fails()) {
            $result = $this->formatInputErrorResponse($validator->errors()->first());
            return $result;
        }

        $loginData = ['email' => $request->email, 'password' => $request->password];

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        $data = [
            'user' => auth()->user(),
            'access_token' => $accessToken
        ];
        
        return $this->formatSuccessResponse('Login successful', $data);

    }
}