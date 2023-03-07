<?php

namespace App\Http\Controllers;

use App\Models\Permision;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Log;
use App\Models\Privilege;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use SebastianBergmann\Exporter\Exporter;

class RoleController extends Controller
{
    public function index(Request $request,$id=null){
        if ($request->user()->cannot('viewAny', Role::class) && $request->user()->cannot('viewAny', Role::class)) {
            return response('Unauthorized', 401);
        }
        if ($id != null) {
            $role = Role::find($id);
            if(!$role){return response('Not Found',404);}
            return response()->json($role);
        }
        return response()->json(Role::get());
    }
    public function store(Request $request)
    {
        if ($request->user()->cannot('create', Role::class)) {
            return response('Unauthorized', 401);
        }
        $this->validate($request, ['name' => 'required|min:1|max:255|unique:Roles', 'permision' => 'required|min:36']);
        $id = Str::uuid()->toString();
        $name = $request->input('name');
        $permision = explode(",", str_replace(" ", "", $request['permision']));
        $role = Role::create(['role_id' => $id, 'name' => $name]);
        foreach ($permision as $p) {
            $d = Permision::where('permision_id',$p)->exists();
            if (!$d) {
                $r = Role::find($id);
                $privilege = Privilege::where('role_id', $id)->delete();
                if ($r && $privilege) {
                    $r->delete();
                    return response('Permision id "'.$p.'" Not Found', 404);
                }
            }
             Privilege::create(['role_id' => $id, 'permision_id' => $p]);
        }
            if ($role) {
                Log::create([
                    'user_id' => Auth::id(),
                    'datetime' => Carbon::now('Asia/Jakarta'),
                    'activity' => 'Add Role(s)',
                    'detail' => 'Add "' . $name . '" role, with id "' . $id . '"'
                ]);
                return response()->json(['message' => 'Role created successfully'], 201);
            } else {
                return response()->json("Failure", 500);
            }
    }
    public function update(Request $request, $id ){
        if ($request->user()->cannot('update', Role::class)) {
            return response('Unauthorizesd', 401);
        }
        $role = Role::find($id);
        $adm = Permision::where('name', 'super-admin')->value('permision_id');
        $priv =  Privilege::where([['permision_id','=',$adm],['role_id','=',$role->role_id]])->first();
        $r = Role::whereIn('role_id',Privilege::where('permision_id',  $adm)->count());
        if (!$role) {return response('Not Found', 404);}
        $privilege = Privilege::where('role_id', $id);$check=false;
        $this->validate($request, ['name' => 'min:1|max:255|unique:Roles,name,' . $role->role_id.',role_id', 'permision' => 'required|min:36']);
        $permision = explode(",", str_replace(" ", "", $request['permision']));
        foreach ($permision as $p) {
            $d = Permision::where('permision_id', $p)->exists();
            if (!$d) {
                    return response('Permision id "' . $p . '" Not Found', 404);
            }
            if($p == $adm){
                $check = true;
            }
        }
        if($priv && !$check && $r <= 1){
            return response()->json('There must be at least one role with admin permision',422);
        }
        $privilege->delete();
        $role->update(['name'=>trim($request['name'])]);
        foreach ($permision as $p) {
            Privilege::create(['role_id' => $id, 'permision_id' => $p]);
        }
        Log::create([
            'user_id' => Auth::id(),
            'datetime' => Carbon::now('Asia/Jakarta'),
            'activity' => 'Update Role(s)',
            'detail' => 'Update "' . $role->name . '" role, with id "' . $id . '"'
        ]);
        return response()->json('Data Updated');
    }
    public function destroy(Request $request, $id){
        if ($request->user()->cannot('delete', Role::class)) {
            return response('Unauthorized', 401);
        }
        $role = Role::find($id);
        $adm = Permision::where('name', 'super-admin')->value('permision_id');
        $priv =  Privilege::where([['permision_id', '=', $adm], ['role_id', '=', $role->role_id]])->first();
        if($priv){
            return response()->json("Can't delete role with 'admin' permision",403);
        }
        $name = $role->name;
        $privilege = Privilege::where('role_id', $id)->delete();
        $role->delete();
        if($role&&$privilege){
            Log::create([
                'user_id' => Auth::id(),
                'datetime' => Carbon::now('Asia/Jakarta'),
                'activity' => 'Delete Role(s)',
                'detail' => 'Delete "' . $name . '" role, with id "' . $id . '"'
            ]);
        return response()->json('Deleted');}
        return response('Failure', 500);
       
    }
    public function trash(Request $request, $id = null)
    {
        if ($request->user()->cannot('viewAny', User::class)) {
            return response('Unauthorized', 401);
        }
        if ($id != null) {
            $trash = Role::onlyTrashed()->find($id);
            if (!$trash) {
                return response('Id Not Found', 404);
            }
            if ($trash->isEmpty()) {
                return response('No Role Trased', 404);
            }
            return response()->json($trash);
        }
        $trash = Role::onlyTrashed()->get();
        if ($trash->isEmpty()) {
            return response('No Role Trased', 404);
        }
        return response()->json($trash);
    }
    public function restore(Request $request)
    {
        if ($request->user()->cannot('viewAny', Role::class)) {
            return response('Unauthorized', 401);
        }
        $this->validate($request, ['role_id' => 'required|min:36']);
        $id = explode(",", str_replace(" ", "", $request['role_id']));
        $restore = Role::whereIn('role_id', $id)->restore();
        if (!$restore) {
            return response('Failure', 500);
        }
        return response('Restore Sucess');
    }
    public function restoreAll(Request $request)
    {
        if ($request->user()->cannot('viewAny', Role::class)) {
            return response('Unauthorized', 401);
        }
        $restore = Role::onlyTrashed()->restore();
        if (!$restore) {
            return response('Failure', 500);
        }
        return response('Restore Sucess');
    }
    public function delete(Request $request)
    {
        if ($request->user()->cannot('viewAny', Role::class)) {
            return response('Unauthorized', 401);
        }
        if ($request->isMethod('DELETE')) {
            $delete = Role::onlyTrashed()->forceDelete();
            if (!$delete) {
                return response('Failure', 500);
            }
            return response('Restore Sucess');
        }
        if ($request->isMethod('POST')) {
            $this->validate($request, ['role_id' => 'required|min:36']);
            $id = explode(",", str_replace(" ", "", $request['role_id']));
            $delete = Role::whereIn('role_id', $id)->forceDelete();
            if (!$delete) {
                return response('Failure', 500);
            }
            return response('Restore Sucess');
        }
        return response('Forbiden Method', 403);
    }
}
