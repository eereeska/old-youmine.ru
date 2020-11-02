<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServerLoginAttempt;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index(Request $r)
    {
        return view('pages.admin.stats', [
            'u' => $r->user(),
            'users' => [
                'registered' => User::select('created_at')->orderBy('created_at')->take(100)->get()->groupBy(function($item) {
                    return $item->created_at->format('d.m.Y');
               })
            ],
            'server' => [
                'login_attempts' => ServerLoginAttempt::orderBy('created_at')->get()->groupBy(function($item) {
                    return $item->created_at->format('d.m.Y');
               })
            ]
        ]);
    }
}