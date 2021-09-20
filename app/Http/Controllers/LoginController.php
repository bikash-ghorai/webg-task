<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Response;
use JWTAuth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);
        if ($token) {
            $user = User::where(['email' => $request->email])->first();
            $name = $user->first_name.' '.$user->last_name;
            $data = (object)['status' => 'Success', 'message' => 'Login Successful. Redirecting...', 'token' => $token, 'user_name' => $name];
            return Response::json($data);
        }else{
            $data = (object)['status' => 'Failed', 'message' => 'Incorrect email & password']; 
            return Response::json($data);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->header('Authorization');
        JWTAuth::invalidate($token);
        $data = (object)['status' => 'Success', 'message' => 'Logout Successful']; 
        return Response::json($data);
    }
}
