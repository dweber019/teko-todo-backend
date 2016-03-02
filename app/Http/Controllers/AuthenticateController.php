<?php

namespace App\Http\Controllers;

use App\Services\ApiResponse;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenticateController extends Controller
{
    public function __construct()
    {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
        $this->middleware('jwt.auth', ['except' => ['store', 'update']]);
    }

    public function index()
    {
        return JWTAuth::parseToken()->authenticate();
    }

    public function store(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return ApiResponse::respondWithError(['invalid credentials'], 'invalid credentials', 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return ApiResponse::respondInternalError(['could not create token']);
        }

        // if no errors are encountered we can return a JWT
        return ApiResponse::respond(['token' => $token]);
    }

    public function update()
    {
        try {
            $token = JWTAuth::refresh(JWTAuth::getToken());
        } catch (JWTException $e) {
            return ApiResponse::respondWithError(['invalid token'], 'invalid token', 401);
        }

        return ApiResponse::respond(['token' => $token]);
    }
}
