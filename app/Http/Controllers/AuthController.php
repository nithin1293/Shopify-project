<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\signin;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email'=> 'required|string|email|unique:users',
            'password'=> 'required|string|min:6',
            'user_type'=> 'required|string|in:customer,store_owner',
        ]);

        $user = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
            'user_type'=> $request->user_type,
        ]);
        Mail::to($user->email)->send(new signin($user));

        $token = JWTAuth::fromuser($user);

        return response()->json([
            'token'=> $token,
            'user' => $user,
        ], 201);
       
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email','password');

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error'=> 'Invalid Credentials'], 401);
        }
        $data['tokendata'] = $this->respondWithToken($token);
        $data['user'] = Auth::user();
        return response()->json($data);
    }

    public function me()
    {
        $user = Auth::user();
        // $user = new UserResource($user);
        return response()->json(['user'=>$user]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Logged out Successfully'],200);
    }

    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    protected function respondWithToken($token)
    {
        return [
            'token'=> $token,
            'token_type'=>'bearer',
            'expires_in'=>Auth::factory()->getTTL() *60
        ];
    }
}