<?php namespace App\Composers;

use Illuminate\Support\Facades\Auth;

class UserComposer
{
    public function compose($view)
    {
        $view->with('u', Auth::check() ? Auth::user() : false);
    }
}