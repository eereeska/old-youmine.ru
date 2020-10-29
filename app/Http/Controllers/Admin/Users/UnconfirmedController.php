<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UnconfirmedController extends Controller
{
    public function index(Request $r)
    {
        return view('pages.admin.users.unconfirmed', [
            'u' => $r->user()
        ]);
    }

    public function search(Request $r)
    {
        return response()->json([
            'success' => true,
            'users' => view('pages.admin.users.unconfirmed.list', [
                'users' => User::where('name', null)->where('vk_first_name', 'like', '%' . $r->get('query') . '%')->orWhere('vk_last_name', 'like', '%' . $r->get('query') . '%')->orWhere('vk_id', 'like', '%' . $r->get('query') . '%')->orWhere('vk_link', 'like', '%' . $r->get('query') . '%')->get()
            ])->render()
        ]);
    }
}