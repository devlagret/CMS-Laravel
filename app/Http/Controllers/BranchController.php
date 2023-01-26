<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Branch;
use App\Models\Token;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Helpers\UserHelper;

class BranchController extends Controller
{
    
    public function index()
    {
        $branches = Branch::get();
  
        return response()->json($branches);
    }

    public function store(Request $request)
    {
        if(!User::where('id',$request->input('user_id'))){
            return response()->json(['message' => 'Username not found, please make sure if username is registered at system '], 401);
        }
        $validator = $this->validate($request, [
            'branch_name'    => 'required',
            'leader_name'    => 'required',
            'contact'        => 'required|max:15',
            'address'        => 'required',
            'user_id' =>'required',
        ]);
        $branch_name = $request->input('branch_name');
        $leader_name = $request->input('leader_name');
        $contact = $request->input('contact');
        $address = $request->input('address');
        $user_id = $request->input('user_id');
    
        $branch = Branch::create([
            'branch_id' => Str::uuid()->toString(),
            'branch_name'    => $branch_name,
            'leader_name'    => $leader_name,
            'contact'    => $contact,
            'address'    => $address,
            'user_id'    => $user_id,
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
    
    public function show($id)
    {
        $branch = Branch::find($id);

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
        
        $branch = Branch::where('branch_id',$id)->update([
            'branch_name'    => $request->input('branch_name'),
            'leader_name'    => $request->input('leader_name'),
            'contact'        => $request->input('contact'),
            'address'        => $request->input('address'),
        ]);
        $uh = new UserHelper;
        if ($branch) {
            Log::create([
                'user_id' => $uh->getUserData($request->header('token'))->user_id,
                'datetime' => Carbon::now('Asia/Jakarta'),
                'activity' => 'Update Branch(s)',
                'detail' => 'Update Branch with name "'.$branch_name.'" Lead by "'.$leader_name
            ]);
            return response()->json(['message' => 'Data added successfully'], 201);
        }else {
            return response()->json("Failure",500);
        }
    }
    
    public function destroy($id)
    {
        Branch::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }

    public function user(){
       $usr = User::join('branches','User.user_id','=','branches.user_id')->get();
        return response()->json($usr);
        
    }
}
