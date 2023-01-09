<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelper ;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Logs;
use App\Models\Tokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{
    //
    public function register(Request $request){
        $token = $request->header('token');
        $uid = Tokens::where('token', '=', $token)->first();
        $usr = Users::where('id', $uid->id)->first();
        if($usr->role == 'admin'){
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
            Logs::create([
                'user_id' => $uid->id,
                'datetime' => Carbon::now('Asia/Jakarta'),
                'activity' => 'Add User(s)',
                'detail' => 'Add "'.$name.'" with username "'.$username.'" and "'.$role.'" role'
            ]); 
        return response()->json(['message' => 'Data added successfully'], 201);
    }
        return response('Unauthorized.role='.$usr->role, 401);

    }
    public function login(Request $request){
        $this->validate($request, [
            'username' => 'required|max:50',
            // 'password' => 'required'
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        $user = Users::where('username', $username)->first();
        if (!$user) {
            return response()->json(['message' => 'Login failed, Username not found'], 401);
        }

        $isValidPassword = Hash::check($password, $user->password);
        if (!$isValidPassword) {
            return response()->json(['message' => 'Login failed, wrong password'], 401);
        }

        $generateToken = bin2hex(random_bytes(50));
        $ftoken = Hash::make($generateToken . $username);
        if (Tokens::where('id', '=', $user->id)->exists()) {
            // user found
            $token = Tokens::where('id', '=', $user->id)->first();
            $token->update(['token' => str_replace('\\', '', $ftoken)]);
        } else {
            $token = Tokens::create([
                'id' => $user->id,
                'token' => str_replace('\\','',$ftoken)
            ]);
        }
        $id = Tokens::where('token', '=', $token->token)->first();
        return response()->json(['token' => $token->token, 'usrn' => hash('crc32b',$username)]);
    }
    public function getuser(Request $request, $id){
        $token = $request->header('token');
        $uid = Tokens::where('token', '=', $token)->first();
        $usr = Users::where('id', $uid->id)->first();
        if(hash('crc32b', $usr->username)==$id){
            $uh = new UserHelper;
            return response()->json(['default'=>$usr, 'formated'=>$uh->getUserData($uid->id)]);
        }
        return response('Unauthorized.', 401);
    }
}
