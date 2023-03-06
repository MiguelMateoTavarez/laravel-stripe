<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = $request->segment(count(request()->segments()));
        
        $user = User::find($userId);

        if(!$user) {
            return response()->json([
                'error' => 'User not found',
            ], 404);
        }

        return $next($request);
    }
}
