<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Location\Facades\Location;

class VKController extends Controller
{
    const VK_API_VERSION = '5.95';

    const VK_CLIENT_ID = 7595518;
    const VK_SECRET = 'cqpCZzpjhUSa4g5XOH7h';

    public function login(Request $r)
    {
        if ($r->has('code')) {
            $token = json_decode(file_get_contents('https://oauth.vk.com/access_token?client_id=' . self::VK_CLIENT_ID . '&client_secret=' . self::VK_SECRET . '&redirect_uri=' . env('VK_REDIRECT', 'http://youmine.loc/login') . '&code=' . $r->code), true);

            if (isset($token['error'])) {
                return redirect('/');
            }

            $data = json_decode(file_get_contents('https://api.vk.com/method/users.get?fields=photo_max_orig,domain&access_token=' . $token['access_token'] . '&v=' . self::VK_API_VERSION), true);

            if (isset($data['error'])) {
                return redirect('/');
            }

            $ip = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $r->ip();
            $country = $_SERVER['HTTP_CF_IPCOUNTRY'];

            $vk_info = $data['response'][0];

            $user = User::where('vk_id', $vk_info['id'])->first();

            if (!$user) {
                $user = new User();
                $user->vk_id = $vk_info['id'];
                $user->reg_ip = $ip;
                $user->reg_country = $country ?? null;
            }

            $user->vk_first_name = $vk_info['first_name'];
            $user->vk_last_name = $vk_info['last_name'];
            $user->vk_avatar = $vk_info['photo_max_orig'];
            $user->country = $country ?? null;
            $user->ip = $ip;

            $user->save();

            Auth::login($user, true);

            return redirect()->route('profile');
        } else {
            return redirect('https://oauth.vk.com/authorize?client_id=' . self::VK_CLIENT_ID . '&display=page&redirect_uri=' . env('VK_REDIRECT', 'http://youmine.loc/login') . '&response_type=code&v=' . self::VK_API_VERSION);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}