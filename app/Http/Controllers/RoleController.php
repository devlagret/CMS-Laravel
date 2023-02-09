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
                $r->delete();
                if ($r && $privilege) {
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
        if (!$role) {return response('Not Found', 404);}
        $privilege = Privilege::where('role_id', $id);
        $this->validate($request, ['name' => 'min:1|max:255|unique:Roles', 'permision' => 'required|min:36']);
        $permision = explode(",", str_replace(" ", "", $request['permision']));
        foreach ($permision as $p) {
            $d = Permision::where('permision_id', $p)->exists();
            if (!$d) {
                    return response('Permision id "' . $p . '" Not Found', 404);
            }
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
}
