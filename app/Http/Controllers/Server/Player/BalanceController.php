<?php

namespace App\Http\Controllers\Server\Player;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function get($name)
    {
        $user = User::where('name', $name)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => '§cНе удалось найти информацию в базе данных'
            ]);
        }

        return response()->json([
            'success' => true,
            'value' => $user->balance,
            'message' => '§6' . $user->balance . ' ' . trans_choice('кредит|кредита|кредитов', $user->balance, [], 'ru')
        ]);
    }

    public function increase(Request $r, $name)
    {
        $user = User::where('name', $name)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => '§cНе удалось найти информацию в базе данных'
            ]);
        }

        $user->balance += (int) $r->sum;
        $user->save();

        return response()->json([
            'success' => true,
            'balance' => $user->balance
        ]);
    }

    public function reduce(Request $r, $name)
    {
        $user = User::where('name', $name)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => '§cНе удалось найти информацию в базе данных'
            ]);
        }

        if ($user->balance < (int) $r->sum) {
            return response()->json([
                'success' => false,
                'message' => '§cНедостаточно средств на балансе'
            ]);
        }

        $user->balance -= (int) $r->sum;
        $user->save();

        return response()->json([
            'success' => true,
            'balance' => $user->balance
        ]);
    }
}