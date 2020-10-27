<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function preLogin(Request $r)
    {
        $user = User::where('name', $r->name)->first();

        if (!$user) {
            return response()->json([
                'allow' => false,
                'message' => ''
            ]);
        }

        if ((!$user->admin and !$user->moderator) and $user->sub_expire_at->lte(now())) {
            return response()->json([
                'allow' => false,
                'message' => 'Подписка закончилась'
            ]);
        }

        // TODO: Проверка на баны

        return response()->json([
            'allow' => true
            // TODO: Скин
        ]);
    }
}