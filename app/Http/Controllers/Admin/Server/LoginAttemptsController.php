<?php

namespace App\Http\Controllers\Admin\Server;

use App\Http\Controllers\Controller;
use App\Models\ServerLoginAttempt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginAttemptsController extends Controller
{
    public function index(Request $r)
    {
        if ($r->ajax() || $r->expectsJson()) {
            $v = Validator::make($r->all(), [
                'searchQuery' => ['required', 'string']
            ], [
                'searchQuery.required' => 'Введите фразу для поиска',
                'searchQuery.string' => 'Неверные параметры запроса',
            ]);

            if ($v->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $v->errors()->first()
                ]);
            }

            $users_matches = User::where('id', 'like', '%' . $r->searchQuery . '%')->orWhere('name', 'like', '%' . $r->searchQuery . '%')->orWhere('vk_first_name', 'like', '%' . $r->searchQuery . '%')->orWhere('vk_last_name', 'like', '%' . $r->searchQuery . '%')->orWhere('ip', 'like', '%' . $r->searchQuery . '%')->pluck('id');

            return response()->json([
                'success' => true,
                'html' => view('pages.admin.server.login_attempts.list', [
                    'attempts' => ServerLoginAttempt::whereIn('user_id', $users_matches)->orWhere('name', 'like', '%' . $r->searchQuery . '%')->with('user')->take(50)->orderBy('created_at', 'desc')->get()
                ])->render()
            ]);
        }

        return view('pages.admin.server.login_attempts.index', [
            'attempts' => ServerLoginAttempt::orderBy('created_at', 'desc')->take(50)->with('user')->get()
        ]);
    }
}