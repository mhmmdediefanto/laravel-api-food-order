<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AbleCreateItem
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = Auth::user();
        if ($user->role_id != 3) {
            return response()->json([
                'message' => 'You are not allowed to create an item',
                'status' => 403
            ]);
        }
        return $next($request);
    }
}
