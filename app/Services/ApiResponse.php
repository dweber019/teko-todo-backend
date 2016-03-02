<?php namespace App\Services;


use Illuminate\Support\Facades\Response;

class ApiResponse {

    /**
     * @param string $message
     * @return mixed
     */
    public static function respondNotFound($details = [], $message = 'Not Found!'){
        return ApiResponse::respondWithError($details, $message, 404);
    }

    public static function respondForbidden($details = [], $message = 'Forbidden!'){
        return ApiResponse::respondWithError($details, $message, 403);
    }

    public static function respondBadRequest($details = [], $message = 'Bad request!'){
        return ApiResponse::respondWithError($details, $message, 400);
    }

    public static function respondInternalError($details = [], $message = 'Internal error!'){
        return ApiResponse::respondWithError($details, $message, 500);
    }

    /**
     * @param array $data
     * @param string $message
     * @return mixed
     */
    public static function respondValidationError($details = [], $message = 'Validation not passed!'){
        return ApiResponse::respondWithError($details, $message, 400);
    }

    /**
     * @param $message
     * @param array $details
     * @return mixed
     */
    public static function respondWithError($details = [], $message, $statusCode = 200){
        return ApiResponse::respond([
          'error' => [
            'message' => $message,
            'status_code' => $statusCode,
            'details' => $details,
          ]
        ], $statusCode);
    }

    /**
     * @param $data
     * @param array $headers
     * @return mixed
     */
    public static function respond($data, $statusCode = 200, $headers = []){
        return Response::json($data, $statusCode, $headers);
    }

}