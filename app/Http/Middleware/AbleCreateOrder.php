<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AbleCreateOrder
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = Auth::user();

        if ($user->role_id != 1 && $user->role_id != 3 && $user->role_id != 2 && $user->role_id != 4) {
            return response()->json(['message' => 'You are not allowed to create an order'], 403);
        }
        return $next($request);
    }
}
