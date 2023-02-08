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
        $group = Permision::orderBy('group')->distinct()->get('group');
        $per = array();
        foreach($group as $v){ $per[$v->group]=Permision::where('group',$v->group)->get(['permision_id', 'label', 'alter as name']); }
        return response()->json($per);
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
        if (!$role) {return response('Not Found', 404);}
        $privilege = Privilege::where('role_id',$id)->get('permision_id');
        if ($privilege->isEmpty()) {return response("Role didn't have any permision", 404);}
        $group = Permision::orderBy('group')->distinct()->get('group');
        $per = array();
        foreach ($group as $v) {
            $per[$v->group] = Permision::where('group', $v->group)->get(['permision_id', 'label as name']);
        }
        return response()->json(['role_id' => $role->role_id,'role_name'=>$role->name,'permision'=>$per]);
    }
}
