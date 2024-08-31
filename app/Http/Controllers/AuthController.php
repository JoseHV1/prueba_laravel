<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

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

    public function login(Request $request){
        $validator = \Validator::make($request->all(), [
            'email' => 'required|string|email|exists:users,email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

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
            ], 402);

        } catch (\Throwable $th) {
            return $th;
            return response()->json([
                'message' => 'Ocurrió un error'
            ], 400);
        }
    }

    public function unauthenticated(){
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }
}
