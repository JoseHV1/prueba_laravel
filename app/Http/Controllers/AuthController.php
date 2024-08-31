<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Http\Requests\UserRequest;

class AuthController extends Controller
{
    // Creation of users
    public function register(UserRequest $request){
        DB::beginTransaction();
        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Successful registration'
            ], 200);

        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred'
            ], 500);
        }
    }

    // Login
    public function login(Request $request){
        $validator = \Validator::make($request->all(), [
            'email' => 'required|string|email|exists:users,email',
            'password' => 'required',
        ]);

        if ($validator->fails()) return response()->json($validator->errors(), 422);

        try {
            if(Auth::attempt(["email" => $request->email, "password" => $request->password])){
                $token = auth()->user()->generateToken();

                User::where('id', auth()->user()->id)->update([
                    'token' => $token ,
                    'expires_at' => date('Y-m-d H:i:s', strtotime('+1 hour'))
                ]);

                return response()->json([
                    'token' => $token,
                    'message' => 'Successful login'
                ], 200);
            }

            return response()->json([
                'message' => 'Erroneous Credentials'
            ], 422);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred'
            ], 500);
        }
    }

    // Logout
    public function logout(Request $request){
        $token = substr($request->header('Authorization'), 7);
        $userData = User::where('token', $token)->update([
            'token' => null,
            'expires_at' => null,
        ]);

        return response()->json([], 200);
    }
}
