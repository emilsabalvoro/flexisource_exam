<?php

namespace App\Http\Controllers;

use App\Constants\ApiConstants;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller;

/** 
 * Class BaseController
 */
class BaseController extends Controller
{
    /**
     * return error response.
     *
     * @param $error
     * @param array $errorData
     * @param int $code
     * @return JsonResponse
     */
    public function sendError($error, $code = 404, $errorData = []): JsonResponse
    {
        $response = [
            ApiConstants::SUCCESS => false,
            ApiConstants::MESSAGE => $error,
        ];

        if (!empty($errorData)) {
            $response[ApiConstants::DATA] = $errorData;
        }

        return response()->json($response, $code);
    }
}