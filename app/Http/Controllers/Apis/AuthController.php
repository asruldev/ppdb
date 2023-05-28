<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        // ini jg bisa diletakkan di route api
        $this->middleware(['auth:api', 'verified'], ['except' => ['login', 'register', 'verify', 'notice', 'resend', 'index']]);
    }

    public function index() {
        $users = User::all();

        foreach ($users as $user) {
            if ($user->hasRole('operation')) {
                $user['operation'] = $user->hasRole('operation');
            }
        }

        return response()->json($user);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ])->sendEmailVerificationNotification();

        return response()->json([
            'status' => true,
            'message' => 'Anda berhasil register, please check email ' . $request->email,
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        $loginValue = $request->only('email', 'password');
        $token = Auth::attempt($loginValue);
        if (!$token) {
            return response()->json([
                'status' => false,
                'message' => 'Email atau password salah',
            ], 403);
        }
        $userLogin = Auth::user();
        return response()->json([
            'status' => true,
            'message' => 'Anda berhasil login',
            'data' => [
                'user' => $userLogin,
                'authorization' => [
                    'type' => 'Bearer',
                    'token' => $token,
                ]
            ],
        ], 200);
    }

    public function logout() {
        $logout = Auth::logout();
        if (!$logout) {
            return response()->json([
                'status' => false,
                'message' => 'Token invalid',
            ], 200);
        }
        return response()->json([
            'status' => true,
            'message' => 'Anda berhasil logout',
        ], 200);
    }

    public function refresh() {
        $token = Auth::refresh();
        $userLogin = Auth::user();
        return response()->json([
            'status' => true,
            'message' => 'Anda berhasil refresh token',
            'data' => [
                'user' => $userLogin,
                'authorization' => [
                    'type' => 'Bearer',
                    'token' => $token,
                ]
            ],
        ], 200);
    }

    public function verify($id, Request $request)
    {
        if (!$request->hasValidSignature()) {
            return response()->json([
                'status' => false,
                'message' => 'Verifying email fails'
            ], 400);
        }

        $user = User::find($id);
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return redirect()->to('/');
    }

    public function notice()
    {
        return response()->json([
            'status' => false,
            'message' => 'Please verify your email'
        ], 400);
    }

    public function resend()
    {
        if (Auth::user()->hasVerifiedEmail()) {
            return response()->json([
                'status' => true,
                'message' => 'Email has verified'
            ], 200);
        }

        Auth::user()->sendEmailVerificationNotification();
        return response()->json([
            'status' => true,
            'message' => 'Anda berhasil register, please check email ' . $request->email,
        ], 201);
    }
}