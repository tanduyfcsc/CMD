<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\ValidatorLoginList;
use file;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class LoginRegisterController extends Controller
{

    /*
    Variable Validator Register, Login
     */
    public $validatorRegister;

    public function __construct(ValidatorLoginList $validatorRegister)
    {

        $this->validatorRegister = $validatorRegister;
        Auth::shouldUse('api');

    }
    /*
    Register API
     */
    public function register(Request $request)
    {

        $validator = $this->validatorRegister->validatorRegister($request);

        $file = $request->file('avatar');
        if ($validator->fails()) {
            return response()->json(['trangThai' => false, 'error' => $validator->messages()], 422);
        }
        $imgLink = 'https://drive.google.com/uc?id=1IpUBpYmthTLWUFqvbSPAiea-iaVpj8N5&export=media';

        $userCreate = User::create([
            'hoTen' => $request->hoTen,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'soDienThoai' => $request->soDienThoai,
            'ngaySinh' => '',
            'gioiTinh' => 'Nam',
            'diaChi' => '',
            'avatar' => $imgLink,
            'trangThai' => 0,
            'phanQuyen' => 0,
        ]);
        if ($userCreate) {
            return json_encode([
                'thongBao' => 'Đăng kí thành công!',
                'data' => $userCreate,
            ]);
        }

    }

    /*
    Login API
     */
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không dúng định dạng',
            'password.required' => 'Mật khẩu không được để trống',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = auth('api')->attempt($validator->validated())) {
            return response()->json(['error' => 'Thông tin đăng nhập sai!'], 422);
        }

        if (auth('api')->user()->trangThai == 1) {
            return response()->json(['error' => 'Tài khoản của bạn bị vô hiệu hóa!'], 422);

        }

        return $this->createNewToken($token);

    }

    /*
    Logout API
     */
    public function logout()
    {

        Auth::guard('api')->logout();
        return response()->json([
            'message' => 'Đăng xuất thành công!',
        ], 200);
    }

    public function getUser(Request $request)
    {
        if (Auth::check()) {
            return response()->json([
                'user' => Auth::user(),
            ]);
        } else {
            return response()->json([
                'status' => 'Không tìm thấy người dùng!',
            ]);
        }
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * Get the token array.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {

        return response()->json([
            'access_token' => $token,
            'user' => auth('api')->user(),

        ], 200);
    }

}
