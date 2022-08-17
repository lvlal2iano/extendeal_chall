<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class XHttpUserIdMiddleware
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
        $error = [
            'data' => [],
            'status' => '403',
            'message' => 'Unauthorized'
        ];

        if($request->headers->has('X-HTTP-USER-ID')){
            $id = $request->header('X-HTTP-USER-ID');
            return User::checkId($id) ? $next($request) : response()->json($error, 403);
        }

        return response()->json($error, 403);
    }
}
