<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $r)
    {
        $u = $r->user();
        $r_ip = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $r->ip();

        return view('pages.profile', [
            'u' => $u,
            'serverAccessActive' => $r_ip == $u->ip
        ]);
    }
}