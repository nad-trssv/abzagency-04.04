<?php

namespace App\Http\Controllers;

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
        $this->tokenService->getToken();

        return redirect()->route('users.index')->with('success', 'You’ve received a token that remains valid for the next 40 minutes!');
    }
}
