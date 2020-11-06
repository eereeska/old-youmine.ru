<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(Request $r)
    {
        $u = Auth::user();

        return view('pages.profile', [
            'u' => $u,
            'server_access_active' => ($_SERVER['HTTP_CF_CONNECTING_IP'] ?? $r->ip()) === $u->ip
        ]);
    }

    public function purchaseSubscription(Request $r)
    {
        if (!$r->ajax()) {
            return redirect()->back();
        }

        $u = $r->user();

        if ($u->admin || $u->moderator || is_null($u->sub_expire_at)) {
            return response()->json([
                'message' => 'У Вас и так пожизненная подписка'
            ]);
        }

        if ($r->has('lifetime') and $r->boolean('lifetime')) {
            if ($u->balance < config('youmine.sub.price.lifetime')) {
                return response()->json([
                    'message' => 'Недостаточно средств на балансе'
                ]);
            }

            $u->balance -= config('youmine.sub.price.lifetime');
            $u->sub_expire_at = null;
            $u->save();

            return response()->json([
                'message' => 'Пожизненная подписка была успешно приобретена'
            ]);
        } else {
            if ($u->balance < config('youmine.sub.price.month')) {
                return response()->json([
                    'message' => 'Недостаточно средств на балансе'
                ]);
            }
            
            $u->balance -= config('youmine.sub.price.month');

            if ($u->sub_expire_at->lt(now())) {
                $u->sub_expire_at = now()->addDays(30);
            } else {
                $u->sub_expire_at = $u->sub_expire_at->addDays(30);
            }

            $u->save();

            return response()->json([
                'message' => 'Подписка была продлена до ' . $u->sub_expire_at->format('d-m-Y')
            ]);
        }
    }
}