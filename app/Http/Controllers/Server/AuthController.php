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
            'skin_textures' => 'eyJ0aW1lc3RhbXAiOjE1ODQ1MzUxNDM3MjgsInByb2ZpbGVJZCI6ImRkZWQ1NmUxZWY4YjQwZmU4YWQxNjI5MjBmN2FlY2RhIiwicHJvZmlsZU5hbWUiOiJEaXNjb3JkQXBwIiwic2lnbmF0dXJlUmVxdWlyZWQiOnRydWUsInRleHR1cmVzIjp7IlNLSU4iOnsidXJsIjoiaHR0cDovL3RleHR1cmVzLm1pbmVjcmFmdC5uZXQvdGV4dHVyZS9lZDkyNGQ0MTRiMzRlMzhmMGI4YzQ4YjBlOWJiNjRiM2VmZjY5NDE1NzM2YzdkNzY0ZDFiM2VhYjc5NTg0NzdjIn19fQ==',
            'skin_signature' => 'ty8rNgidVosIhCchXeEqbhl09O+wDcamL9lvXiiRH4h4m+gFjKWoFCigAn533xogmqtTQC1bSfOMA9GW5I6UbdNV+wj8fvXM8qJ5ZC0WwofJiwCwj2vqTCsSdBH77ma6yqesCNewGbxYVXUenphuo7Lh5W2odfJFMztAHqYeBn5DoBSd/+qsfRxl6MliFO2ayfIIWm5SROm9SEqUdynS48Q+pDvJ7kw8xkJZZIoeQMDzyIw9eAzKqhHqRbtktiZurK96EUlrGDvI41HrL/Y9pRY/xh3tLKqBaC4ndkak8COcovNGr/x7JGw47tu3x0jJBhwyEI/nPKL3W5gQb0huyYlmTacSvZH1yHBxxgH7GEz+AbiVhrtCWKkKm+ZrcQ8fekQ2GlDGXMGqIBijDfWKva9B/SvlY6CctKWCKoLIuESiF6a2SkAq13cSI1b4s6uPiUwAiwpyQJWfBLXvg35ihjmxevzrjapBB5VHFgrXLXV5yErJftPVEzYxqm8xblZStMQFJepO5zF8LknCLh4PGpAM2I9hp9ylWR7+Ztfon5fIcur2UNd0lcpTlfC3aZcB3QmYSVKYlnOuw4sPXUMV5/5oNCa5mL3V3cPT9cTmRZm5cQ1boRXl36BcgnB9hMQf9Krbef3IJz25y/F7bhUnCYLVjr0l5Rh4olRpEVTn0To='
        
            // TODO: Скин
        ]);
    }
}