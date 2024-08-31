<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Models\Log;

class VerifyToken
{
    public function handle(Request $request, Closure $next): Response
    {
        // Header validation
        $header = $request->header('Authorization');
        if(!$header){
            return response()->json([
                'message' => 'Token required'
            ], 422);
        }

        // Token validation
        $token = substr($header, 7);

        $userData = User::where('token', $token)->first();
        $currentDatetime = date('Y-m-d H:m:s');

        if(!$userData || $currentDatetime >= date('Y-m-d H:m:s', strtotime($userData->expires_at))){
            return response()->json([
                'message' => 'Unauthorized, the token has expired'
            ], 401);
        }

        if((env('APP_ENV') == 'production' && $request->method() == "POST") || env('APP_ENV') == 'local') $this->insertLog($request->method(), $request->ip(), $userData->id);

        return $next($request);
    }

    // Log insertion
    private function insertLog($method, $ip, $id_user){
        Log::create([
            'id_user' => $ip,
            'action' => "Information ".($method == "POST" ? 'input' : 'output'),
            'ip' => $id_user
        ]);
    }
}
