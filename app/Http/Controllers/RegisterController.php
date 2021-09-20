<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Response;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $already = User::where(['email' => $request->email])->first();
        if (empty($already)) {
            User::create([
                'user_id' => 'USR'.time(),
                'first_name' => $request->fname,
                'last_name' => $request->lname,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password)
            ]);
            $login_url = url("login");
            $data = (object)['status' => 'Success', 'message' => 'Registration Successful, Please <a href="'.$login_url.'">Login</a>'];
            return Response::json($data);
        }else{
            $data = (object)['status' => 'Failed', 'message' => 'You Already Registered With Us, Please login'];
            return Response::json($data);
        }
    }
}
