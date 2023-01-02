<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Tokens;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    //
    public function register(Request $request){
        $this->validate($request, [
            'name' => 'required|min:3|max:50',
            'username' => 'required|unique:users|min:3|max:50',
            'password' => 'required|min:6|',
            'role' => 'min:1|required|max:25'
        ]);
        $name = $request->input('name');
        $username = $request->input('username');
        $password = Hash::make($request->input('password'));
        $role = $request->input('role');
        $user = Users::create([
            'name' => $name,
            'username' => $username,
            'password' => $password,
            'role' => $role
        ]);

        return response()->json(['message' => 'Data added successfully'], 201);
    }
    public function login(Request $request){
        $this->validate($request, [
            'username' => 'required|min:3|max:50',
            'password' => 'required|min:6|'
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        $user = Users::where('username', $username)->first();
        if (!$user) {
            return response()->json(['message' => 'Login failed'], 401);
        }

        $isValidPassword = Hash::check($password, $user->password);
        if (!$isValidPassword) {
            return response()->json(['message' => 'Login failed'], 401);
        }

        $generateToken = bin2hex(random_bytes(50));
        $ftoken = Hash::make($generateToken . $username);
        if (Tokens::where('id', '=', $user->id)->exists()) {
            // user found
            $token = Tokens::where('id', '=', $user->id)->first();
            $token->update(['token' => $ftoken]);
        } else {
            $token = Tokens::create([
                'id' => $user->id,
                'token' => $ftoken
            ]);
        }
        $id = Tokens::where('token', '=', $token->token)->first();
      
        return response()->json(['token' => $token->token]);
    }
    public function getuser(Request $request){
        $this->validate($request, [
            'username' => 'required|min:3|max:50',
            'password' => 'required|min:6|'
        ]);

        $username = $request->input('username');
        $password = $request->input('password');
    }
}
