<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //

    public function postregister(Request $request)
    {
      
        // $request->validate([
        //     'email' => 'required|string|email',
        //     'password' => 'required|string',
        // ]);
        
        // $credentials = $request->only('email', 'password');
        // $token = Auth::attempt($credentials);

        

        // if (!$token) {
        //     return response()->json([
        //         'message' => 'Username Dan Password Anda Salah',
        //     ], 401);
        // }

        // $user = Auth::user();

        
        return response()->json([
            'user' => $request,
            'authorization' => [
                'token' => 'test',
                'type' => 'bearer',
            ]
        ]);
    }

    public function register(Request $request)
    {
        
        $request->validate([
            'username'=>'required:unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        // $credentials = $request->only('username','name','email', 'password');
        // echo json_encode($credentials);
        // exit;
        
        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ]);
    }
    public function getregister(){
        return response()->json([
            'message' => 'OK',
            'user' => 'TESTING'
        ]);
    }
}
