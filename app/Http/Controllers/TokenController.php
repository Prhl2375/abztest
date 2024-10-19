<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    public function indexAction(): JsonResponse
    {
        $tokenStr = Str::random(60);

        Token::create(['token' => $tokenStr]);

        return response()->json([
            'success' => true,
            'token' => $tokenStr,
        ]);
    }
}
