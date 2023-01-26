<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelper;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Log;
use App\Models\Token;
use Illuminate\Support\Facades\Auth;
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
                'name' => 'required|min:3',
                'username' => 'required|unique:User|min:3',
                'password' => 'required|min:6|',
                'contact' => 'required|min:10|max:15',
                'email' => 'required|min:5|email',
                'role_id' => 'min:10'
            ]);
            $name = $request->input('name');
            $username = $request->input('username');
            $password = Hash::make($request->input('password'));
            $role = $request->input('role');
            $uid = Str::uuid()->toString();
            $user = User::create([
                'user_id' => $uid,
                'name' => $name,
                'username' => $username,
                'contact' => $request->input('contact'),
                'email' => $request->input('email'),
                'password' => $password,
                'role' => $role
            ]);
            Log::create([
                'user_id' => Auth::id(),
                'datetime' => Carbon::now('Asia/Jakarta'),
                'activity' => 'Add User(s)',
                'detail' => 'Add new user with user id : '.$uid
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

        $user = User::where('username', $username)->first();
        if (!$user) {
            return response()->json(['message' => 'Login failed, Username not found'], 401);
        }
        if (!Hash::check($password, $user->password)) {
            return response()->json(['message' => 'Login failed, wrong password'], 401);
        }

        $ftoken = Hash::make(bin2hex(random_bytes(50)) . $username);
        Token::updateOrCreate(['user_id' => $user->user_id], ['token' => str_replace('\\', bin2hex(random_bytes(1)), $ftoken)]);
        return response()->json(['token' => $ftoken]);
    }
    public function update(Request $request, $id = null)
    {
        $this->validate($request, [
            'name' => 'min:3|max:50',
            'username' => '|min:3|max:50',
            'old_password' => 'min:6',
            'new_password' => 'min:6',
            'role_id' => 'min:3|max:25'
        ]);
        $token = $request->header('token');
        $name = $request->input('name');
        $username = $request->input('username');
        $newPassword = Hash::make($request->input('new_password'));
        $role = $request->input('role_id');
        $uh = new UserHelper;
        try {
            if ($id == null) {
                $user = User::where('user_id', $uh->getUserData($token, 'user_id'))->first();
                if (!Hash::check($request, $user->password)) 
                {
                    return response()->json(['message' => 'wrong password'], 401);
                };
                $user->update([
                    'name' => $name,
                    'username' => $username,
                    'password' => $newPassword,
                ]);
            } elseif ($uh->getRole($token) == 'admin') {
                $user = User::where('user_id', $id)->first();
                if (!$user) {
                    return response()->json(['message' => 'Update failed, UID not found'], 404);
                }
                $user->update([
                    'name' => $name,
                    'username' => $username,
                    'password' => $newPassword,
                    'role_id' => $role
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
        Log::create([
            'user_id' => $uh->getUserData($token)->user_id,
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
            if (!User::destroy($id)) {
            }
            if ($user) {
                Log::create([
                    'user_id' => $uh->getUserData($token)->user_id,
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
            return response()->json(Auth::user());
        }
    }
    public function getAllUser(Request $request, $id = null)
    {
        $uh = new UserHelper;
        if ($request->user()->cannot('viewAll', User::class)) {
            return response()->json($request->user());
        }
        return response()->json($uh->getAllUser());
    }
}
