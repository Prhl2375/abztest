<?php

namespace App\Http\Middleware;

use App\Models\Token;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = Token::where('token', $request->header('token'))->first();



        if (!$token || $token['used'] || Carbon::parse($token['created_at'])->diffInMinutes(Carbon::now()) > 40) {
            return response()->json([
                'success' => false,
                'message' => 'The token expired.',
            ], 401);
        }else{
            $token['used'] = 1;
            $token->save();
        }
        return $next($request);
    }
}
