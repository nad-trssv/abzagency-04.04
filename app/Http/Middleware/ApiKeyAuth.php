<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\AppClient;

class ApiKeyAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken() ?? $request->cookie('app_token');

        if ($request->expectsJson()) {
            if (!$token) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized: token missing.',
                ], 401);
            }
        }

        $client = AppClient::where('api_key', $token)
            ->where('expires_at', '>', now())
            ->first();

        if (!$client) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'The token expired.',
                ], 401);
            }
    
            return redirect('/users')
                ->with('error', 'The token expired.');
        }

        $request->merge(['app_client' => $client]);
        return $next($request);
    }
}