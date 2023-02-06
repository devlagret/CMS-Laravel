<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelper;
use App\Models\Permision;
use App\Models\Privilege;
use App\Models\Role;
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
        if ($request->user()->can('create', User::class)) {
            $this->validate($request, [
                'name' => 'required|min:3',
                'username' => 'required|unique:User|min:3',
                'password' => 'required|min:6|',
                'contact' => 'required|min:10|max:15',
                'email' => 'required|min:5|email',
                'role_id' => 'required|min:36|max:36'
            ]);
            $name = trim($request->input('name'));
            $username = trim($request->input('username'));
            $password = Hash::make($request->input('password'));
            $role = trim($request->input('role_id'));
            $uid = Str::uuid()->toString();
            if (!Role::find($role)) {
                return response('Role id Not Found', 404);}
            $user = User::create([
                'user_id' => $uid,
                'name' => $name,
                'username' => $username,
                'contact' => $request->input('contact'),
                'email' => $request->input('email'),
                'password' => $password,
                'role_id' => $role
            ]);
            Log::create([
                'user_id' => Auth::id(),
                'datetime' => Carbon::now('Asia/Jakarta'),
                'activity' => 'Add User(s)',
                'detail' => 'Add new user with user id : '.$uid
            ]);
            if ($user) {
                return response()->json(['message' => 'Data added successfully'], 201);
            }else{
                return response()->json("Failure", 500);
            }
        }
        return response('Unauthorized', 401);
    }
    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|max:50',
            'password' => 'required'
        ]);
        $username = trim($request->input('username'));
        $password = $request->input('password');

        $user = User::where('username', $username)->first();
        if (!$user) {
            return response()->json(['message' => 'Login failed, Username not found'], 401);
        }
        if (!Hash::check($password, $user->password)) {
            return response()->json(['message' => 'Login failed, wrong password'], 401);
        }
        $privilege = Privilege::where('role_id', $user->role_id)->get('permision_id');
        $per = Permision::whereIn('permision_id', $privilege)->get(['alter as name']);
        $permision = array();
        foreach ( $per as $v){array_push($permision,$v->name);}
        $ftoken = Hash::make(bin2hex(random_bytes(50)) . $username);
        Token::updateOrCreate(['user_id' => $user->user_id], ['token' => str_replace("\\", random_bytes(1), $ftoken)]);
        return response()->json(['token' => $ftoken,'permision'=>$permision,]);
    }
    public function update(Request $request, $id = null)
    {
        if ($request->user()->cannot('update', User::class)) {
            return response('Unauthorized', 401);
        }
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
        if ($request->user()->can('delete', User::class)) {
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
            if ($request->user()->cannot('viewAny', User::class)) {
                return response('Unauthorized', 401);
            }
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
        if ($request->user()->cannot('viewAny', User::class)) {
            return response('Unauthorizsed',401);
        }
        return response()->json($uh->getAllUser());
    }
    public function trash(Request $request, $id = null)
    {
        if ($request->user()->cannot('viewAny', User::class)) {
            return response('Unauthorized', 401);
        }
        if($id!=null){
            $trash = User::onlyTrashed()->find($id);
            if(!$trash){return response('Id Not Found',404);}
            if($trash->isEmpty()){return response('No User Trased',404);}
           return response()->json($trash);
        }
        $trash = User::onlyTrashed()->get();
        if($trash->isEmpty()){return response('No User Trased', 404);}
        return response()->json($trash);
    
    }
    public function restore(Request $request)
    {
        if ($request->user()->cannot('viewAny', User::class)) {
            return response('Unauthorized', 401);
        }
        $this->validate($request, ['user_id'=>'required|min:36']);
        $id = explode(",", str_replace(" ", "", $request['user_id']));
        $restore = User::whereIn('user_id',$id)->restore();
        if(!$restore){
            return response('Failure',500);
        }
        return response('Restore Sucess');
    }
    public function restoreAll(Request $request)
    {
        $restore = User::onlyTrashed()->restore();
        if (!$restore) {
            return response('Failure', 500);
        }
        return response('Restore Sucess');
    }
    public function delete(Request $request)
    {
        if ($request->user()->cannot('viewAny', User::class)) {
            return response('Unauthorized', 401);
        }
        if ($request->isMethod('DELETE')) {
            $delete = User::onlyTrashed()->forceDelete();
            if (!$delete) {
                return response('Failure', 500);
            }
            return response('Restore Sucess');
        }
        if ($request->isMethod('POST')) {
            $this->validate($request, ['user_id' => 'required|min:36']);
            $id = explode(",", str_replace(" ", "", $request['user_id']));
            $delete = User::whereIn('user_id', $id)->forceDelete();
            if (!$delete) {
                return response('Failure', 500);
            }
            return response('Restore Sucess');
        
        }
        return response('Forbiden Method', 403);
    }
}
