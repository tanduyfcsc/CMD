<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendResetPasswordEmailJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetsPasswordController extends Controller
{
    public function viewResetPassword()
    {
        return view('Admin.Login.resetsPassword');
    }

    public function postResetPassword(Request $request)
    {
        $validator = $request->validate([
            'email' => ['required', 'email'],

        ], [
            'email.required' => 'Email không được để trống',
        ]);

        $user = User::where('email', $request->email)
            ->where(function ($query) {
                $query->where('phanQuyen', 1)
                    ->orWhere('phanQuyen', 3);
            })
            ->first();

        if (!$user) {
            return redirect()->back()->withErrors(['errors' => 'Email chưa được đăng kí']);
        }

        $password = Str::random(8);

        $user->update([
            'password' => Hash::make($password),
        ]);

        SendResetPasswordEmailJob::dispatch($request->email, $password);

        return redirect()->back()->with('success', 'Hãy kiểm tra email của bạn');

    }
}
