<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            if ($user->role == 0) {
                return response()->json(['success' => false, 'message' => 'App not available for admin'], 401);
            }
            if ($user->status == 0) {
                return response()->json(['success' => false, 'message' => 'Your account not actived yet, Pleas ewait till active'], 401);
            } else if ($user->status == 2) {
                return response()->json(['success' => false, 'message' => 'Your account blocked, Please contact to upmanager200@gmail.com'], 401);
            }
            // $data['token'] =  $user->createToken($user->id)->accessToken;
            $data['token'] =  bcrypt($user->id);
            $data['user'] =  $user;

            return response()->json(['success' => true, "data" => $data, 'message' => "login success"], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Unauthorised'], 401);
        }
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phonenumber' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 401);
        }


        $input = $request->all();
        if (User::where('email', $input['email'])->count() > 0) {
            return response()->json(['success' => false, "data" => "exists"], 200);
        }
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        return response()->json(['success' => true, "data" => $user], 200);
    }
}
