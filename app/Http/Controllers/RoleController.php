<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function index(){
        return response()->json(Role::get());
    }
    public function store(Request $request){
        $this->validate($request, ['name' => 'required|min:1|max:255']);
        $name = $request->input('name');
        $id = Str::uuid()->toString();
        $role = Role::create(['role_id'=> $id,'name'=>$name]);

        if($role){
            Log::create([
                'user_id' => Auth::id(),
                'datetime' => Carbon::now('Asia/Jakarta'),
                'activity' => 'Add Role(s)',
                'detail' => 'Add "'.$name.'" role, with id "'.$id.'"'
            ]);
            return response()->json(['message' => 'Role created successfully',201]);
        }else{
            return response()->json("Failure", 500);
        }
    }
}
