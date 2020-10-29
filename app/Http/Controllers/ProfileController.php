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