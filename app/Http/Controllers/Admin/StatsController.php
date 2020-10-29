<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index(Request $r)
    {
        return view('pages.admin.stats', [
            'u' => $r->user()
        ]);
    }
}