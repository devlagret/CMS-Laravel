<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Branch;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Helpers\UserHelper;

class BranchController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->user()->cannot('viewAny', Branch::class)) {
            return response('Unauthorized', 401);
        }
        $branches = Branch::paginate(9);
  
        return response()->json($branches);
    }

    public function store(Request $request)
    {
        if ($request->user()->cannot('create', Branch::class)) {
            return response('Unauthorized', 401);
        }
        if(!User::where('user_id',$request->input('user_id'))){
            return response()->json(['message' => 'Username not found, please make sure if username is registered at system '], 401);
        }
        $validator = $this->validate($request, [
            'branch_name'    => 'required',
            'leader_name'    => 'required',
            'contact'        => 'required|max:15',
            'address'        => 'required',
            'user_id'        => 'required',
        ]);
        $branch_name = $request->input('branch_name');
        $leader_name = $request->input('leader_name');
        $contact = $request->input('contact');
        $address = $request->input('address');
        $user_id = $request->input('user_id');
    
        $branch = Branch::create([
            'branch_id'   => Str::uuid()->toString(),
            'branch_name' => $branch_name,
            'leader_name' => $leader_name,
            'contact'     => $contact,
            'address'     => $address,
            'user_id'     => $user_id,
        ]);
        $uh = new UserHelper;
         if ($branch) {
             Log::create([
                 'user_id' => $uh->getUserData($request->header('token'))->user_id,
                 'datetime' => Carbon::now('Asia/Jakarta'),
                 'activity' => 'Add Branch(s)',
                 'detail' => 'Add Branch with name "'.$branch_name.'" Lead by "'.$leader_name
             ]);
             return response()->json(['message' => 'Data added successfully'], 201);
         } else {
             return response()->json("Failure",500);
         }
    }
    
    public function show(Request $request , $id)
    {
        if ($request->user()->cannot('view', Branch::class)||$request->user()->cannot('viewAny', Branch::class)) {
            return response('Unauthorized', 401);
        }
        $branch = Branch::find($id);
        if (!$branch) {
            return response()->json(['message' => 'Data not found'], 404);
        }
        return response()->json($branch);
    }

    public function showByName(Request $request)
    {
        if ($request->user()->cannot('viewAny', Branch::class)&&$request->user()->cannot('viewAny', Branch::class)) {
            return response('Unauthorized', 401);
        }
        $validator = $this->validate($request, [
            'branch_name' => 'required',
        ]);

        $name = $request->input('branch_name');
        $supplier = Branch::where('branch_name', 'LIKE', '%'.$name.'%')->paginate(9);

        return response()->json($supplier);
    }

    public function update(Request $request, $id)
    {
        if ($request->user()->can('update', Branch::class)) {
            $validator = $this->validate($request, [
                'branch_name'    => 'required',
                'leader_name'    => 'required',
                'contact'        => 'required|max:15',
                'address'        => 'required',
                'user_id'        => 'required',
            ]);
            $branch_name = $request->input('branch_name');
            $leader_name = $request->input('leader_name');
            
            $branch = Branch::where('branch_id',$id)->update([
                'branch_name'    => $request->input('branch_name'),
                'leader_name'    => $request->input('leader_name'),
                'contact'        => $request->input('contact'),
                'address'        => $request->input('address'),
            ]);
        }elseif ($request->user()->can('updateb', Branch::class)) {
            $validator = $this->validate($request, [
                'branch_name'    => 'required',
                'leader_name'    => 'required',
                'contact'        => 'required|max:15',
                'address'        => 'required',
            ]);
            $branch_name = $request->input('branch_name');
            $leader_name = $request->input('leader_name');
            
            $branch = Branch::where('branch_id',$id)->update([
                'branch_name'    => $request->input('branch_name'),
                'leader_name'    => $request->input('leader_name'),
                'contact'        => $request->input('contact'),
                'address'        => $request->input('address'),
            ]);
        }else {
            return response('Unauthorized', 401);
        }
        // $uh = new UserHelper;
        // if ($branch) {
        //     Log::create([
        //         'user_id' => $uh->getUserData($request->header('token'))->user_id,
        //         'datetime' => Carbon::now('Asia/Jakarta'),
        //         'activity' => 'Update Branch(s)',
        //         'detail' => 'Update Branch with name "'.$branch_name.'" Lead by "'.$leader_name
        //     ]);
        //     return response()->json(['message' => 'Data added successfully'], 201);
        // }else {
        //     return response()->json("Failure",500);
        // }
        return response()->json($branch,200);
    }
    
    public function destroy(Request $request,$id)
    {
        if ($request->user()->cannot('delete', Branch::class)) {
            return response('Unauthorized', 401);
        }
        Branch::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }

    public function user(Request $request)
    {
        if ($request->user()->cannot('viewAny', Branch::class)) {
            return response('Unauthorized', 401);
        }
       $usr = User::join('branches','User.user_id','=','branches.user_id')->get();
        return response()->json($usr);
        
    }
    public function trash(Request $request, $id = null)
    {
        if ($request->user()->cannot('viewAny', User::class)) {
            return response('Unauthorized', 401);
        }
        if ($id != null) {
            $trash = Branch::onlyTrashed()->find($id);
            if (!$trash) {
                return response('Id Not Found', 404);
            }
            if ($trash->isEmpty()) {
                return response('No Branch Trased', 404);
            }
            return response()->json($trash);
        }
        $trash = Branch::onlyTrashed()->get();
        if ($trash->isEmpty()) {
            return response('No Branch Trased', 404);
        }
        return response()->json($trash);
    }
    public function restore(Request $request)
    {
        if ($request->user()->cannot('viewAny', Branch::class)) {
            return response('Unauthorized', 401);
        }
        $this->validate($request, ['branch_id' => 'required|min:36']);
        $id = explode(",", str_replace(" ", "", $request['branch_id']));
        $restore = Branch::whereIn('branch_id', $id)->restore();
        if (!$restore) {
            return response('Failure', 500);
        }
        return response('Restore Sucess');
    }
    public function restoreAll(Request $request)
    {
        if ($request->user()->cannot('viewAny', Branch::class)) {
            return response('Unauthorized', 401);
        }
        $restore = Branch::onlyTrashed()->restore();
        if (!$restore) {
            return response('Failure', 500);
        }
        return response('Restore Sucess');
    }
    public function delete(Request $request)
    {
        if ($request->user()->cannot('viewAny', Branch::class)) {
            return response('Unauthorized', 401);
        }
        if ($request->isMethod('DELETE')) {
            $delete = Branch::onlyTrashed()->forceDelete();
            if (!$delete) {
                return response('Failure', 500);
            }
            return response('Restore Sucess');
        }
        if ($request->isMethod('POST')) {
            $this->validate($request, ['branch_id' => 'required|min:36']);
            $id = explode(",", str_replace(" ", "", $request['branch_id']));
            $delete = Branch::whereIn('branch_id', $id)->forceDelete();
            if (!$delete) {
                return response('Failure', 500);
            }
            return response('Restore Sucess');
        }
        return response('Forbiden Method', 403);
    }
}
