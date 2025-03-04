<?php

namespace App\Traits;

trait ApiResponseTrait
{
    /**
     * Success response.
     *
     * @param  mixed   $data
     * @param  string  $message
     * @param  int     $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($data, $message = 'Operation successful', $statusCode = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Error response.
     *
     * @param  string  $message
     * @param  int     $statusCode
     * @param  mixed   $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($message = 'Operation failed', $statusCode = 400, $errors = null)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'errors' => $errors,
        ], $statusCode);
    }
}