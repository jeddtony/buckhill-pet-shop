<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminAuthController extends Controller
{
    public function register(Request $request)
    {

        $validatedData = $request->validate([
            'first_name' => 'required|max:55',
            'last_name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required',
            'address' => 'required|max:255',
            'phone_number' => 'required|max:255',
        ]);

        
        $validatedData['password'] = bcrypt($request->password);
        $validatedData['uuid'] = Str::uuid();
        $validatedData['is_admin'] = true;
        
        $user = User::create($validatedData);

        
        $access_token = $user->createToken('authToken')->accessToken;
        
        
        $data = [
            'user' => $user,
            'access_token' => $access_token
        ];
        return $this->formatCreatedResponse('Registration successful', $data);
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email'    => 'required',
            'password' => 'required'
        ]);


        if($validator->fails()) {
            $result = $this->formatInputErrorResponse($validator->errors());
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