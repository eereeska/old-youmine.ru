<?php

namespace App\Http\Controllers\Server;

use App\Events\Server\LoginAttemptEvent;
use App\Http\Controllers\Controller;
use App\Models\Skin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function preLogin(Request $r)
    {
        $user = User::where('name', $r->name)->first();

        event(new LoginAttemptEvent($user, $r->name, $r->ip));

        // if (!$user) {
        //     return response()->json([
        //         'allow' => false,
        //         'message' => "§c（￣︶￣）↗\n\n§cМы Вас не знаем, но можем познакомиться\n\n§2Чтобы попасть на сервер, нужно:\n\n§71. §fПройти авторизацию на нашем сайте\n§72. §fИметь активную подписку\n§73. §fАктивный §8\"§eДоступ к серверу§8\"§f\n\n§fПройти авторизацию можно на нашем сайте:\n§9youmine.ru/profile\n"
        //     ]);
        // }

        // TODO: Проверка на баны

        if ($user) {
            $skin = Skin::where('id', $user->skin_id)->first();
        } else {
            $skin = false;
        }

        if (!$skin) {
            $skin = Skin::where('id', 1)->first();
        }

        return response()->json([
            'allow' => true,
            'exists' => !!$user,
            'ip' => $r->ip,
            'skin_texture' => $skin->texture,
            'skin_signature' => $skin->signature
        ]);
    }

    public function register(Request $r)
    {
        if (User::where('name', $r->name)->exists()) {
            return response()->json([
                'success' => false,
                'message' => '§cПользователь с никнеймом "' . $r->name . '" уже зарегистрирован на сервере'
            ]);
        }

        $v = Validator::make($r->all(), [
            'password' => ['required', 'min:6']
        ], [
            'password.required' => '§cПароль не указан',
            'password.min' => '§cМинимальная длинна пароля: 6 символов'
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->errors()->first()
            ]);
        }

        $user = new User();
        $user->name = $r->name;
        $user->password = Hash::make($r->password);
        $user->save();

        return response()->json([
            'success' => true
        ]);
    }

    public function login(Request $r)
    {
        $user = User::where('name', $r->name)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => '§cПользователь не найден в базе данных'
            ]);
        }

        if (Hash::check($r->password, $user->password)) {
            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => '§cНеверный пароль'
        ]);
    }
}