<?php

namespace App\Http\Middleware;


class login
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if ($request->session()->has('user')) {
            
        }else{
            return route('login');
        }
    }
}
