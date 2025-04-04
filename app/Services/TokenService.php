<?php

namespace App\Services;

use App\Models\AppClient;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class TokenService
{
    /**
     * Create a new class instance.
     */
    
    public function getToken()
    {
        $token = Str::random(64);
        AppClient::updateOrCreate(
            ['api_key' => $token],
            ['expires_at' => now()->addMinutes(40)]
        );
        
        Cookie::queue('app_token', $token, 40);

        return $token;
    }
}
