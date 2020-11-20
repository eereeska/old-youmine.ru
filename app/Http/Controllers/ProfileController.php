<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        return view('pages.profile');
    }

    public function changePassword(Request $r)
    {
        $v = Validator::make($r->all(), [
            'current' => ['required'],
            'new' => ['required']
        ], [
            'current.required' => 'Не указан текущий пароль',
            'new.required' => 'Не указан новый пароль',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors(['change-password' => $v->errors()->first()]);
        }
        
        $u = Auth::user();

        if (!Hash::check($r->current, $u->password)) {
            return redirect()->back()->withErrors(['change-password' => 'Неверный текущий пароль']);
        }

        if (strlen($r->new) < 6) {
            return redirect()->back()->withErrors(['change-password' => 'Минимальная длинна пароля: 6 символов']);
        }

        $u->password = Hash::make($r->new);
        $u->save();

        return redirect()->back()->with('change-password', 'Пароль был успешно изменён');
    }
}