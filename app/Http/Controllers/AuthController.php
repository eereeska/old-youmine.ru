<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        // $this->middleware('throttle:3,10')->only('login');
    }
    
    public function index()
    {
        return view('pages.auth.login');
    }

    public function login(Request $r)
    {
        $v = Validator::make($r->all(), [
            'name' => ['required'],
            'password' => ['required']
        ], [
            'name.required' => 'Обязательное поле',
            'password.required' => 'Обязательное поле',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withInput($r->input())->withErrors($v->errors());
        }

        $user = User::where('name', $r->name)->first();

        if (!$user or !Hash::check($r->password, $user->password)) {
            return redirect()->back()->withInput($r->input())->withErrors(['wrong_credentials' => 'Неверный логин или пароль']);
        }

        Auth::login($user, true);

        return redirect()->route('profile');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('home');
    }
}