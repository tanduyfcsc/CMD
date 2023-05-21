<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Jobs\SendResetPasswordEmailJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ], [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email phải đúng định dạng',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'Email này chưa được đăng kí'], 422);
        }

        $password = Str::random(8);

        $user->update([
            'password' => Hash::make($password),
        ]);

        SendResetPasswordEmailJob::dispatch($request->email, $password);

        return response()->json(['message' => 'Hãy kiểm tra email'], 200);
    }

}
