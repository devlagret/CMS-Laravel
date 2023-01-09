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
        $uh = new UserHelper;
        if($uh->getRole($token) == 'admin'){
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
        $id = $uh->getUserData($token);
        $user = Users::create([
            'name' => $name,
            'username' => $username,
            'password' => $password,
            'role' => $role
        ]);
            Logs::create([
                'user_id' => $id['id'],
                'datetime' => Carbon::now('Asia/Jakarta'),
                'activity' => 'Add User(s)',
                'detail' => 'Add "'.$name.'" with username "'.$username.'" and with`` "'.$role.'" role'
            ]); 
        return response()->json(['message' => 'Data added successfully'], 201);
    }
        return response('Unauthorized', 401);

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
        if (! Hash::check($password, $user->password)) {
            return response()->json(['message' => 'Login failed, wrong password'], 401);
        }

        $ftoken = Hash::make(bin2hex(random_bytes(50)) . $username);
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
        return response()->json(['token' => $token->token, 'usrn' => hash('crc32b',$username)]);
    }
    public function getuser(Request $request, $id){
        $token = $request->header('token');
        $uh = new UserHelper;
        $d = $uh->getUserData($token);
        if(hash('crc32b', $d['username'])==$id){
            return response()->json($d);
        }
        return response('Unauthorized.', 401);
    }
}
