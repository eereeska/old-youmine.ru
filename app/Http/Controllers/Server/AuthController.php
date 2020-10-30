<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function preLogin(Request $r)
    {
        $user = User::where('ip', $r->ip)->first();

        if (!$user) {
            return response()->json([
                'allow' => false,
                'message' => 'Мы Вас не знаем, уходите'
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

        if ((!$user->admin and !$user->moderator) and $user->sub_expire_at->lte(now())) {
            return response()->json([
                'allow' => false,
                'message' => 'Подписка отсутствует'
            ]);
        }

        // TODO: Проверка на баны

        return response()->json([
            'allow' => true,
            'skin_textures' => 'ewogICJ0aW1lc3RhbXAiIDogMTYwNDA1MjU1NzE5NiwKICAicHJvZmlsZUlkIiA6ICJlNzkzYjJjYTdhMmY0MTI2YTA5ODA5MmQ3Yzk5NDE3YiIsCiAgInByb2ZpbGVOYW1lIiA6ICJUaGVfSG9zdGVyX01hbiIsCiAgInNpZ25hdHVyZVJlcXVpcmVkIiA6IHRydWUsCiAgInRleHR1cmVzIiA6IHsKICAgICJTS0lOIiA6IHsKICAgICAgInVybCIgOiAiaHR0cDovL3RleHR1cmVzLm1pbmVjcmFmdC5uZXQvdGV4dHVyZS9lZDkyNGQ0MTRiMzRlMzhmMGI4YzQ4YjBlOWJiNjRiM2VmZjY5NDE1NzM2YzdkNzY0ZDFiM2VhYjc5NTg0NzdjIiwKICAgICAgIm1ldGFkYXRhIiA6IHsKICAgICAgICAibW9kZWwiIDogInNsaW0iCiAgICAgIH0KICAgIH0KICB9Cn0=',
            'skin_signature' => 'b/hVz4PMsFchztOu9kZjuSUHLfCE8wJe9tSMUWiMEwwi3mF5ceLhi70RzhBqWripoJ51Epot+xGFLvzqDMqi6zy0CIKxpNM80FWDy3hr2Y900u46EUgSVk6kJB9jjuWVtu18HODtyiBd16Yay3SnrPob16VibU5XEN/KsQvRhFzraEn2q2KH+rF67rsWq0iTd8Shq9QB3GXgcoiUCsNlitN/kNhUW4xzBaIPJuni6VwUQA8Z77gVoNgj76ba6jIvCNCmb9wHB0I46UXTpSUUhvI0qecgsb/ZIAhoLj6ypfx+OFskPexizazKLQhiIwanNJ1gQJGM3mJBVyr6vDE2bEJ4uQCIIdFAFZ4qNxdzezztfU/x1mt7+VeLU3Qhql1NuTTBQfO71JGE0e+yGQYq2US0QGg4lUqtjtwq+dMUzfjm+5PCqegJs/0HbX3jXr5L9UNCpbvnv6ImTsm6zDRPKYtNSFUmXFGtRfrz/DkdSYTBAapIB2wrV7j59NSi8cQTxQR9zwJ3Hq+9etN04n3zaOHBp81WgzLeuzdCrZk3rKXsHwePwj4mJMPm3E07ebK/km6/Hztok2YKqLHFBu97RMAYsI+mrHaEF4MalV64U5GG0NNiAxuxhnuY5rWaP5U1ie8IeUPw7LtZ/ORmE5sjoujG++ht7DnU8idgABk51Q0='
            // TODO: Скин
        ]);
    }
}