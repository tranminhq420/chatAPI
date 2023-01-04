<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Token;
use Laravel\Passport\TokenRepository;


class PassportController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            if (Auth::user() == null) return response(['message' => 'Unauthenticated']);
            return $next($request);
        });
    }
    public function getToken($id)
    {
        $token = Token::where('id', $id)->first();
        return response([
            'id' => $token->id,
            'username' => $token->user->username,
            'expires' => $token->expires_at
        ]);
    }
    public function revokeToken($id)
    {
        $tokenRepository = app(TokenRepository::class);
        $tokenRepository->revokeAccessToken($id);
        return response(["message" => "Logged out"]);
    }
}