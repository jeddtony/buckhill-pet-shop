<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function getUserDetails(Request $request)
    {
        //
        $user = auth()->user();
        return $this->formatSuccessResponse('User details', $user);
    }
}
