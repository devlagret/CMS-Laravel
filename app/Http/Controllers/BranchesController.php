<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Branches;

class BranchesController extends Controller
{
    public function index()
    {
        $branches = Branches::get();
  
        return response()->json($branches);
    }

    
    public function store(Request $request)
    {
        if(!Users::where('username',$request->input('login_username'))){
            return response()->json(['message' => 'Username not found, please make sure if username is registered at system '], 401);
        }
        $addbranch = Branches::create([
        
        ]);
        $branch = new Branches;
        $branch->branch_name = $request->branch_name;
        $branch->leader_name = $request->leader_name;
        $branch->contact = $request->contact;
        $branch->address = $request->address;
        $branch->login_username = $request->login_username;
        $branch->login_password	 = $request->login_password	;
        $branch->save();

        return response()->json($branch);
    }

    
    public function show($id)
    {
        $branch = Branches::find($id);

        return response()->json($branch);
    }

    public function update(Request $request, $id)
    {
        // $branch = Branches::find($id);
        // $branch = new Branches;
        // $branch->branch_name = $request->branch_name;
        // $branch->leader_name = $request->leader_name;
        // $branch->contact = $request->contact;
        // $branch->address = $request->address;
        // $branch->login_username = $request->login_username;
        // $branch->login_password	 = $request->login_password;
        // $branch->save();
        $branch = Branches::whereId($id)->update([
            'category_name'  => $request->input('category_name'),
            'category_type'  => $request->input('category_type'),
            'branch_name'    => $request->input('branch_name'),
            'leader_name'    => $request->input('leader_name'),
            'contact'        => $request->input('contact'),
            'address'        => $request->input('address'),
            'login_username' => $request->input('login_username'),
            // login_password	 = $request->login_password,
        ]);

        return response()->json($branch);
    }

    
    public function destroy($id)
    {
        Branches::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
