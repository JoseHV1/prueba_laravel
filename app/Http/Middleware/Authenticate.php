<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Log;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        $token = substr($request->header()['authorization'][0], 7);
        $userData = User::where('token', $token)->first();
        $currentDatetime = date('Y-m-d H:m:s');
        if(date('Y-m-d H:m:s', strtotime($userData->expires_at)) >= $currentDatetime){
            return route('redirectUnauthenticated');
        }

        if((env('APP_ENV') == 'production' && $request->method() == "POST") || env('APP_ENV') == 'local') {
            Log::create([
                'id_user' => $userData->id,
                'action' => $request->method() == "POST" ? 'Information input' : 'Information output',
                'ip' => $request->ip()
            ]);
        }

        return null;
    }
}

