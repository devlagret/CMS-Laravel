<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Branches;
use App\Models\Tokens;
use App\Models\Logs;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Helpers\UserHelper;

class BranchesController extends Controller
{
    
    public function index()
    {
        $branches = Branches::get();
  
        return response()->json($branches);
    }

    public function store(Request $request)
    {
        if(!Users::where('id',$request->input('uid'))){
            return response()->json(['message' => 'Username not found, please make sure if username is registered at system '], 401);
        }
        $validator = $this->validate($request, [
            'branch_name'    => 'required',
            'leader_name'    => 'required',
            'contact'        => 'required|max:15',
            'address'        => 'required',
            'uid' =>'required',
        ]);
        $branch_name = $request->input('branch_name');
        $leader_name = $request->input('leader_name');
        $contact = $request->input('contact');
        $address = $request->input('address');
        $uid = $request->input('uid');
    
        $branch = Branches::create([
            'branch_id' => Str::uuid()->toString(),
            'branch_name'    => $branch_name,
            'leader_name'    => $leader_name,
            'contact'    => $contact,
            'address'    => $address,
            'uid'    => $uid,
        ]);
        $uh = new UserHelper;
         if ($branch) {
             Logs::create([
                 'user_id' => $uh->getUserData($request->header('token'))->uid,
                 'datetime' => Carbon::now('Asia/Jakarta'),
                 'activity' => 'Add Branch(s)',
                 'detail' => 'Add Branch with name "'.$branch_name.'" Lead by "'.$leader_name
             ]);
             return response()->json(['message' => 'Data added successfully'], 201);
         } else {
             return response()->json("Failure");
         }
    }

    
    public function show($id)
    {
        $branch = Branches::find($id);

        return response()->json($branch);
    }

    public function update(Request $request, $id)
    {
        $validator = $this->validate($request, [
            'branch_name'    => 'required',
            'leader_name'    => 'required',
            'contact'        => 'required|max:15',
            'address'        => 'required',
        ]);
        $branch_name = $request->input('branch_name');
        $leader_name = $request->input('leader_name');
        
        $branch = Branches::whereId($id)->update([
            'branch_name'    => $request->input('branch_name'),
            'leader_name'    => $request->input('leader_name'),
            'contact'        => $request->input('contact'),
            'address'        => $request->input('address'),
        ]);
        $uh = new UserHelper;
        if ($branch) {
            Logs::create([
                'user_id' => $uh->getUserData($request->header('token'))->uid,
                'datetime' => Carbon::now('Asia/Jakarta'),
                'activity' => 'Update Branch(s)',
                'detail' => 'Update Branch with name "'.$branch_name.'" Lead by "'.$leader_name
            ]);
            return response()->json(['message' => 'Data added successfully'], 201);
        }else {
            return response()->json("Failure");
        }
    }

    
    public function destroy($id)
    {
        Branches::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
