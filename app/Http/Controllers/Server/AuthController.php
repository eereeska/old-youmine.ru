<?php

namespace App\Http\Controllers\Server;

use App\Events\Server\LoginAttemptEvent;
use App\Http\Controllers\Controller;
use App\Models\Skin;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function preLogin(Request $r)
    {
        $user = User::where('ip', $r->ip)->first();

        event(new LoginAttemptEvent($user, $r->name, $r->ip));

        if (!$user) {
            return response()->json([
                'allow' => false,
                'message' => "§cМы Вас не знаем, уходите\n\n§fРегистрация и авторизация происходит на нашем сайте:\n§9youmine.ru/profile"
            ]);
        }

        if (is_null($user->name)) {
            $user->name = $r->name;
            $user->save();
        } else if ($user->name !== $r->name) {
            return response()->json([
                'allow' => false,
                'message' => 'Вы пытаетесь войти под чужим никнеймом'
            ]);
        }

        if ((!$user->admin and !$user->moderator) and (!is_null($user->sub_expire_at) and $user->sub_expire_at->lte(now()))) {
            return response()->json([
                'allow' => false,
                'message' => "§cПодписка отсутствует\n\n§fКупить можно на нашем сайте, в профиле:\n§9youmine.ru/profile\n\n§7На месяц: §f100 рублей §8(§6200 коинов§8)\n§7Навсегда: §f500 рублей §8(§61000 коинов§8)"
            ]);
        }

        // TODO: Проверка на баны

        $skin = Skin::where('id', $user->skin_id)->first();

        if (!$skin) {
            $skin = Skin::where('id', 1)->first();
        }

        return response()->json([
            'allow' => true,
            'skin_texture' => $skin->texture,
            'skin_signature' => $skin->signature
        ]);
    }
}