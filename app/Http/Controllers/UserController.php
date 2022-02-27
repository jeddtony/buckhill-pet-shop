<?php

namespace App\Http\Controllers;

use App\Models\User;
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

    public function users(Request $request)
    {
        // return list of users that are not admins
        $users = User::where('is_admin', false)->get();

        return $this->formatSuccessResponse('Users', $users);
    }
}
