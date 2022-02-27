<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * 
     *  @OA\Get(
     *      path="/api/v1/user",
     *      operationId="getUserDetail",
     *      tags={"Users"},
     *      summary="Get a user detail",
     *      description="Returns user detail",
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
     
     * Get all payments.
     *
     * @return Response
     */
    public function getUserDetails(Request $request)
    {
        //
        $user = auth()->user();
        return $this->formatSuccessResponse('User details', $user);
    }

     /**
     * 
     *  @OA\Get(
     *      path="/api/v1/admin/user-listing",
     *      operationId="getUsers",
     *      tags={"Admin"},
     *      summary="Get list of Users",
     *      description="Returns list of Users",
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
     
     * Get all payments.
     *
     * @return Response
     */
    public function users(Request $request)
    {
        // return list of users that are not admins
        $users = User::where('is_admin', false)->get();

        return $this->formatSuccessResponse('Users', $users);
    }
}
