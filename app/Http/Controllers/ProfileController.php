<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index(Request $r)
    {
        $u = $r->user();
        $r_ip = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $r->ip();

        return view('pages.profile', [
            'u' => $u,
            'serverAccessActive' => $r_ip == $u->ip
        ]);
    }

    public function purchaseSubscription(Request $r)
    {
        if (!$r->ajax()) {
            return redirect()->back();
        }

        $u = $r->user();

        if ($u->admin || $u->moderator || is_null($u->sub_expire_at)) {
            return response()->json([
                'message' => 'У Вас и так пожизненная подписка'
            ]);
        }

        if ($r->boolean('lifetime')) {
            if ($u->balance < 200) {
                return response()->json([
                    'message' => 'Недостаточно средств на балансе'
                ]);
            }
            
            $u->balance -= 200;

            if ($u->sub_expire_at->lt(now())) {
                $u->sub_expire_at = now()->addDays(30);
            } else {
                $u->sub_expire_at = $u->sub_expire_at->addDays(30);
            }

            $u->save();

            return response()->json([
                'message' => 'Подписка была продлена до ' . $u->sub_expire_at->format('d-m-Y')
            ]);
        } else {
            if ($u->balance < 1000) {
                return response()->json([
                    'message' => 'Недостаточно средств на балансе'
                ]);
            }

            $u->balance -= 1000;
            $u->sub_expire_at = null;
            $u->save();

            return response()->json([
                'message' => 'Пожизненная подписка была успешно приобретена'
            ]);
        }
    }

    public function update(Request $r)
    {
        $u = $r->user();

        $v = Validator::make($r->all(), [
            'name' => ['min:3', 'max:16', 'regex:/^[A-Za-z0-9_]*$/']
        ], [
            'name.min' => 'Минимальная длинна никнейма: 3 символа',
            'name.max' => 'Максимальная длинна никнейма: 16 символов',
            'name.regex' => 'Никнейм может содержать лишь буквы латинского алфавита, цифры и нижнее подчёркивание'
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors(['message' => $v->errors()->first()]);
        }

        if ($r->has('name')) {
            $u->name = $r->name;
        }

        $u->save();

        return redirect()->back();
    }
}