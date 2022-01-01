<?php

namespace App\Http\Middleware\MyMiddlewares;

use Closure;
use Illuminate\Http\Request;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        $users = User::all();
        if($users->tokens()->where('token', Hash::chech($token))){
            return response()->json([
                'status' => '401',
                'message' => 'Sorry, you are not logged in.',
            ]);
        }
        
        return $next($request);
    }
}
