<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function toggle(Request $r)
    {
        $u = $r->user();

        if ($r->target == 'serverAccess') {
            $r_ip = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $r->ip();

            if (is_null($u->ip)) {
                $u->ip = $r_ip;
            } else {
                if ($u->ip == $r_ip) {
                    $u->ip = null;
                } else {
                    $u->ip = $r_ip;
                }
            }
            
            $u->save();

            return response()->json([
                'success' => true,
                'active' => $u->ip != null
            ]);
    }

        return response()->json([
            'success' => false,
            'message' => 'Указан неверный параметр'
        ]);
    }
}