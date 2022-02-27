<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{

      /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Pet Shop API Documentation",
     *      description="Documentation for Pet Shop API",
     *      @OA\Contact(
     *          email="admin@admin.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="Pet Shop API Server"
     * )

     *
     *
     */

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function formatSuccessResponse(string $message, $data)
    {
        return response()->json(
            ['status' => true, 'message' => $message, 'data' => $data], 200);
    }

    public function formatCreatedResponse(string $message, $data)
    {
        return response()->json(
            ['status' => true, 'message' => $message, 'data' => $data], 201);
    }

    public function formatInputErrorResponse(string $message)
    {
        
        return response()->json(['status' => false, 'message' => $message], 422);
    }

    public function notFoundResponse(string $message)
    {
        return response()->json(['status' => false, 'message' => $message], 404);
    }

    public function formatDeletedResponse(string $message)
    {
        
        return response()->json(['status' => true, 'message' => $message], 200);
    }
}
