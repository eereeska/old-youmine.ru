<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
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

            return response()->json([
                'success' => true,
                'html' => view('pages.admin.users.list', [
                    'users' => User::where('id', 'like', '%' . $r->searchQuery . '%')->orWhere('name', 'like', '%' . $r->searchQuery . '%')->orWhere('vk_first_name', 'like', '%' . $r->searchQuery . '%')->orWhere('vk_last_name', 'like', '%' . $r->searchQuery . '%')->orWhere('ip', 'like', '%' . $r->searchQuery . '%')->get()
                ])->render()
            ]);
        }
        
        return view('pages.admin.users.index', [
            'users' => User::orderBy('created_at', 'desc')->take(50)->get()
        ]);
    }

    public function edit(Request $r, $id)
    {
        if ($r->isMethod('POST')) {
            $user = User::where('id', $id)->first();

            if (json_encode($user) !== $r->original) {
                return redirect()->back()->withErrors(['message' => 'Данные редактируемого пользователя не соответствуют актуальным данным пользователя']);
            }
            
            $user->name = $r->name;
            $user->balance = $r->balance;
            $user->admin = $r->boolean('admin');
            $user->moderator = $r->boolean('moderator');
            $user->sub_expire_at = $r->sub_expire_at == 'null' ? null : Carbon::parse($r->sub_expire_at);

            $user->save();

            return redirect()->route('admin-users-edit', ['id' => $user->id]);
        }

        return view('pages.admin.users.edit', [
            'user' => User::where('id', $id)->first()
        ]);
    }
}