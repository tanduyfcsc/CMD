<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentManagementMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $phanQuyen = $user->phanQuyen;
            $trangThai = $user->trangThai;

            if ($trangThai == 0 && ($phanQuyen == 1 || $phanQuyen == 3)) {
                return $next($request);
            } else {
                return redirect()->back();
            }

        }
        return redirect()->back();

    }
}
