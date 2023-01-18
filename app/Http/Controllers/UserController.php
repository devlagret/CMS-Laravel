<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelper;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Logs;
use App\Models\Tokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;



class UserController extends Controller
{


    protected  $uh = new UserHelper;
    //
    public function register(Request $request)
    {
        $token = $request->header('token');
        if ($this->uh->getRole($token) == 'admin') {
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
            //$id = $uh->getUserData($token);
            $user = Users::create([
                'uid' => Str::uuid()->toString(),
                'name' => $name,
                'username' => $username,
                'password' => $password,
                'role' => $role
            ]);
            Logs::create([
                'uid' => $this->uh->getUserData($token)->uid,
                'datetime' => Carbon::now('Asia/Jakarta'),
                'activity' => 'Add User(s)',
                'detail' => 'Add "' . $name . '" with username "' . $username . '" and with`` "' . $role . '" role'
            ]);
            return response()->json(['message' => 'Data added successfully'], 201);
        }
        return response('Unauthorized', 401);
    }
    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|max:50',
            'password' => 'required'
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        $user = Users::where('username', $username)->first();
        if (!$user) {
            return response()->json(['message' => 'Login failed, Username not found'], 401);
        }
        if (!Hash::check($password, $user->password)) {
            return response()->json(['message' => 'Login failed, wrong password'], 401);
        }

        $ftoken = Hash::make(bin2hex(random_bytes(50)) . $username);
        if (Tokens::where('uid', '=', $user->uid)->exists()) {
            // user found
            $token = Tokens::where('uid', '=', $user->uid)->first();
            $token->update(['token' => str_replace('\\', '', $ftoken)]);
        } else {
            $token = Tokens::create([
                'uid' => $user->uid,
                'token' => str_replace('\\', '', $ftoken)
            ]);
        }
        return response()->json(['token' => $token->token]);
    }
    public function getUser(Request $request, $id = null)
    {
        if ($id != null) {
            $uh = new UserHelper;
            $d = $uh->getUserById($id);
            return response()->json($d);
        } else {
            $token = $request->header('token');
            $uh = new UserHelper;
            $d = $uh->getUserData($token);
            return response()->json($d);
        }
    }
    public function getAllUser(Request $request, $id = null)
    {
            $uh = new UserHelper;
            return response()->json($uh->getAllUser());
    }
}
