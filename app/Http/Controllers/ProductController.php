<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Response;
use JWTAuth;

class ProductController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function getAllProduct(){
        $list = Product::get()->load('userInfo');
        $data = (object)['status' => 'Success', 'data' => $list];
        return Response::json($data);
    }

    public function store(Request $request)
    {
        $token = $request->header('Authorization');
        if (isset($request->proid)) {
            $product = Product::where(['id' => $request->proid])->update([
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description
            ]);
        }else{
            $user = JWTAuth::authenticate($token);
            $product = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'add_by_user' => $user->user_id
            ]);
            $product->userInfo = $user;
        }
        $data = (object)['status' => 'Success', 'data' => $product];
        return Response::json($data);
    }

    public function edit($id)
    {
        $product = Product::where(['id' => $id])->first();
        $data = (object)['status' => 'Success', 'data' => $product];
        return Response::json($data);
    }

    public function delete($id)
    {
        $product = Product::where(['id' => $id])->delete();
        $data = (object)['status' => 'Success', 'data' => $product];
        return Response::json($data);
    }
}
