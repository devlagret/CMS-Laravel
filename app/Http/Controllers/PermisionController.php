<?php

namespace App\Http\Controllers;

use App\Models\Permision;
use App\Models\Privilege;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class PermisionController extends Controller
{
    //
    public function index(Request $request){
        if ($request->user()->cannot('viewAny', Permision::class)) {
            return response('Unauthorized', 401);
        }
        $permision = Permision::orderBy('group')->get(['permision_id','label as name','group']);
        return response()->json($permision);
    }
    public function view(Request $request,$id){
        if ($request->user()->cannot('viewAny', Permision::class)) {
            return response('Unauthorized', 401);
        }
        $permision = Permision::find($id);
        if(!$permision){return response('Not Found', 404);}
        return response()->json($permision);
    }
    public function viewrole(Request $request, $id){
        if ($request->user()->cannot('viewAny', Permision::class)) {
            return response('Unauthorized', 401);
        }
        $role = Role::find($id);
        $privilege = Privilege::where('role_id',$id)->get('permision_id');
        if ($privilege->isEmpty()) {return response('Role id Not Found', 404);}
        $permision = Permision::whereIn('permision_id', $privilege)->get(['permision_id','label','group']);
        return response()->json(['role_id' => $role->role_id,'role_name'=>$role->name,'permision'=>$permision]);
    }
}
