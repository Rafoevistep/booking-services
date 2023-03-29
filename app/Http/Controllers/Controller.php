<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function ResponseJson($responseData): JsonResponse
    {
        return response()->json([
            'error' => null,
            'data' => $responseData,
        ]);
    }

    public function ErrorResponseJson($errorMessage): JsonResponse
    {
        return response()->json([
            'error' => $errorMessage,
        ]);
    }
}
