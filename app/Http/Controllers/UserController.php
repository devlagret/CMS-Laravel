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


    //
    public function register(Request $request)
    {
        $uh = new UserHelper;
        $token = $request->header('token');
        if ($uh->getRole($token) == 'admin') {
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
                'uid' => Str::uuid()->toString(),
                'name' => $name,
                'username' => $username,
                'password' => $password,
                'role' => $role
            ]);
            Logs::create([
                'uid' => $uh->getUserData($token)->uid,
                'datetime' => Carbon::now('Asia/Jakarta'),
                'activity' => 'Add User(s)',
                'detail' => 'Add "' . $name . '" with username "' . $username . '" and with "' . $role . '" role'
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
        Tokens::updateOrCreate(['uid' => $user->uid], ['token' => str_replace('\\', bin2hex(random_bytes(1)), $ftoken)]);
        return response()->json(['token' => $ftoken]);
    }
    public function update(Request $request, $id = null)
    {
        $this->validate($request, [
            'name' => 'min:3|max:50',
            'username' => '|min:3|max:50',
            'password' => 'min:6',
            'role' => 'min:3|max:25'
        ]);
        $token = $request->header('token');
        $name = $request->input('name');
        $username = $request->input('username');
        $password = Hash::make($request->input('password'));
        $role = $request->input('role');
        $uh = new UserHelper;
        try {
            if ($id == null) {
                $user = Users::where('uid', $uh->getUserData($token, 'uid'))->first();
                $user->update([
                    'name' => $name,
                    'username' => $username,
                    'password' => $password,
                ]);
            } elseif ($uh->getRole($token) == 'admin') {
                $user = Users::where('uid', $id)->first();
                if (!$user) {
                    return response()->json(['message' => 'Update failed, UID not found'], 404);
                }
                $user->update([
                    'name' => $name,
                    'username' => $username,
                    'password' => $password,
                    'role' => $role
                ]);
                
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == '1062') {
                return response()->json(['message' => 'Update failed, Username Already Taken'], 409);
            }
          
        }
        if (!$user) {
            return response()->json(['message' => 'Update failed, UID not found'], 404);
        }
        Logs::create([
            'uid' => $uh->getUserData($token)->uid,
            'datetime' => Carbon::now('Asia/Jakarta'),
            'activity' => 'Update User(s)',
            'detail' => 'Update user to : name "' . $user->name . '", username "' . $user->username . '" and with "' . $user->role . '" role'
        ]);
        return response()->json(['message' => 'Data updated successfully'], 200);
    }
    public function destroy(Request $request, $id)
    {
        $uh = new UserHelper;
        $token = $request->header('token');
        $user = $uh->getUserByid($id);
        if ($uh->getRole($token) == 'admin') {
                return response(
            'Failed', 404);
            if (!Users::destroy($id)) {
            }
            if ($user) {
                Logs::create([
                    'uid' => $uh->getUserData($token)->uid,
                    'datetime' => Carbon::now('Asia/Jakarta'),
                    'activity' => 'Delete User(s)',
                    'detail' => 'Deleted user with name "' . $user->name . '", username "' . $user->username . '" and with "' . $user->role . '" role'
                ]);
            }
            return response()->json(['message' => 'Deleted']);
        }
        return response('Unauthorized', 401);
    }
    public function getUser(Request $request, $id = null)
    {
        if ($id != null) {
            $uh = new UserHelper;
            $d = $uh->getUserById($id);
            if(!$d){
                return response('Not Found', 404);
            }
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
