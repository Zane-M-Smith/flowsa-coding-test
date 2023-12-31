<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return response()->json(
            [
                'user' => auth()->user(),
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]
        );
    }
    // public function register(Request $request)
    public function register(RegisterRequest $request)
    {
        $user = User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]
        );
        $user->assignRole('user');
        $response = [];
        $responseCode = 500;
        if ($token = Auth::login($user)){
          $response = [
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
          ];
          $responseCode = 201;
        }else{
          $response = [
            'error' => 'unable to login user',
            ];
            $responseCode = 500;
        }
        return response()->json(
          $response,
          $responseCode
      );
    }

    public function logout()
    {
        Auth::logout();

        return response()->json(
            [
                'status' => 'success',
            ]
        );
    }

    public function refresh()
    {
        return response()->json(
            [
                'user' => Auth::user(),
                'authorisation' => [
                    'token' => Auth::refresh(),
                    'type' => 'bearer',
                ]
            ]
        );
    }
}
