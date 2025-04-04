<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TokenService;

class TokenController extends Controller
{
    protected TokenService $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    } 

    public function getToken()
    {
        $token = $this->tokenService->getToken();

        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }
}
