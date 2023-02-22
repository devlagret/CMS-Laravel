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
        if ($request->user()->can('create', User::class)) {
            $this->validate($request, [
                'name' => 'required|min:3',
                'username' => 'required|unique:User|min:3',
                'password' => 'required|min:6|confirmed',
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
        $uh =new UserHelper;
        Token::updateOrCreate(['user_id' => $user->user_id], ['token' => str_replace("\\", random_bytes(1), $ftoken)]);
        return response()->json(['token' => $ftoken,'pos'=>$uh->getPosition($user->user_id),'permision'=>$permision,]);
    }
    public function update(Request $request, $id = null)
    {
        $name = $request->input('name');
        $username = $request->input('username');
        try {
            if ($id == null) {
                if ($request->user()->cannot('update', User::class)) {
                    return response('Unauthorized', 401);
                }
                $user = User::where('user_id',Auth::id())->first();
                if (!$user) {
                    return response()->json(['message' => 'Update failed, UID not found'], 404);
                }
                $this->validate($request, [
                    'name' => 'required|min:3|max:255',
                    'username' => 'required|min:3|max:255|unique:User,username,' . $user->user_id . ',user_id',
                    'contact' => 'required|min:12|max:15',
                    'email' => 'required|email|min:3|max:255'
                ]);
                if (!Hash::check($request->input('password'), $user->password)) 
                {
                    return response()->json(['message' => 'wrong password'], 401);
                };
                $user->update([
                    'username' => $username,
                    'name' => $name,
                    'contact' =>$request->input('contact'),
                    'email'=>$request->input('email'),
                ]);
                Log::create([
                    'user_id' => Auth::id(),
                    'datetime' => Carbon::now('Asia/Jakarta'),
                    'activity' => 'Update User Profile',
                    'detail' => "User Update Profile"
                ]);
            } if ($request->user()->can('updateAny',User::class)) {
                $user = User::where('user_id', $id)->first();
                if (!$user) {
                    return response()->json(['message' => 'Update failed, UID not found'], 404);
                }
                $this->validate($request, [
                    'name' => 'required|min:3|max:255',
                    'username' => 'required|min:3|max:255|unique:User,username,' . $user->user_id . ',user_id',
                    'contact' => 'required|min:12|max:15',
                    'email' => 'required|email|min:3|max:255',
                    'role_id'=>'required|min:36|max:36'
                ]);
        $role = $request->input('role_id');
                
              $c =   $user->update([
                    'name' => $name,
                    'username' => $username,
                    'contact' =>$request->input('contact'),
                    'email'=>$request->input('email'),
                    'role_id' => $role
                ]);
                Log::create([
                    'user_id' => Auth::id(),
                    'datetime' => Carbon::now('Asia/Jakarta'),
                    'activity' => 'Update User(s)',
                    'detail' => 'Update user to : name "' . $user->name . '", username "' . $user->username . '" and with "' . $user->role . '" role'
                ]);
                if($c){
        return response()->json(['message' => 'Data updated successfully'], 200);
                }else{
        return response()->json(['message' => 'Error'], 500);
                }
            }
            return response()->json(['message' => 'Unauthorized'], 401);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == '1062') {
                return response()->json(['message' => 'Update failed, Username Already Taken'], 409);
            }
          
        }
       
        return response()->json(['message' => 'why are you here?'], 400);
    }
    public function updatePassword(Request $request,$id = null)
    {
        if($id==null){
            $this->validate($request,['password'=> 'required|min:6|confirmed']);
            $password = $request->input('password');
            $user = User::find(Auth::id());
            if(Hash::check($password, $user->password)){
            return response()->json(['message' => 'New Password Can Not the Same with Old Password'], 400);}
            $up = $user->update([
                'password' => $password,
            ]);
            Log::create([
                'user_id' => Auth::id(),
                'datetime' => Carbon::now('Asia/Jakarta'),
                'activity' => 'Update Password',
                'detail' => "Update User Password"
            ]);
            if($up){
                return response()->json(['message' => 'Updated']);
            } else {
                return response()->json('error', 500);
            }
        }elseif($request->user()->can('updateAnyPassword')){
            $this->validate($request, ['password' => 'required|min:6|confirmed']);
            $password = $request->input('password');
            $user = User::find($id);
            if (Hash::check($password, $user->password)) {
                return response()->json(['message' => 'New Password Can Not the Same with Old Password'], 400);
            }
            $up = $user->update([
                'password' => $password,
            ]);
            Log::create([
                'user_id' => Auth::id(),
                'datetime' => Carbon::now('Asia/Jakarta'),
                'activity' => 'Update User Password',
                'detail' => "Update User With id : '".$id."' Password "
            ]);
            if ($up) {
                return response()->json(['message' => 'Updated']);
            }else{return response()->json('error',500);}
        }return response()->json('Unauthorized',401);
    }
    public function resetPassword(Request $request, $id = null)
    {
        if($id==null){
            $request->validate(['password' => 'required|min:6|confirmed']);
       $usr = User::find($id);
            $up = $usr->update([
                'password' => $request->input('password'),
            ]);
            Log::create([
                'user_id' => Auth::id(),
                'datetime' => Carbon::now('Asia/Jakarta'),
                'activity' => 'Update User Password',
                'detail' => "User Update Password "
            ]);
            if ($up) {
                return response()->json(['message' => 'Updated']);
            } else {
                return response()->json('error', 500);
            }
        }
       $usr = User::find(Auth::id());
        $request->validate(['password' => 'required|min:6|confirmed']);
        $up = $usr->update([
            'password' => $request->input('password'),
        ]);
        Log::create([
            'user_id' => Auth::id(),
            'datetime' => Carbon::now('Asia/Jakarta'),
            'activity' => 'Update User Password',
            'detail' => "Update User With id : '" . $id . "' Password "
        ]);
        if ($up) {
            return response()->json(['message' => 'Updated']);
        }else{return response()->json('error',500);}
    }
    public function destroy(Request $request, $id)
    {
        $user = User::find($id);
        if ($request->user()->can('delete', User::class)) {
            if (!User::destroy($id)) {
                return response()->json('Failed', 404);
            }
            if ($user) {
                Log::create([
                    'user_id' =>Auth::id(),
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
           $d = User::find($id);
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
    public function getAllUser(Request $request)
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
