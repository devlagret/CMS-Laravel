<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branches;
use App\Models\Tokens;
use App\Models\Users;
use App\Models\Logs;
use Carbon\Carbon;

class BranchesController extends Controller
{
    public function index()
    {
        $branches = Branches::get();
  
        return response()->json($branches);
    }

    public function store(Request $request)
    {
        $token = $request->header('token');
        $uid = Tokens::where('token', '=', $token)->first();
        $usr = Users::where('id', $uid->id)->first();

        $validator = $this->validate($request, [
            'branch_name'    => 'required',
            'leader_name'    => 'required',
            'contact'        => 'required|max:15',
            'address'        => 'required',
        ]);
        $branch_name = $request->input('branch_name');
        $leader_name = $request->input('leader_name');
        $contact = $request->input('contact');
        $address = $request->input('address');
        $login_username = $request->input('login_username');
    
        $branch = Branches::create([
            'branch_name'    => $branch_name,
            'leader_name'    => $leader_name,
            'contact'    => $contact,
            'address'    => $address,
            'login_username'    => $login_username,
        ]);

        if ($branch) {
            Logs::create([
                'user_id' => $uid->id,
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
        $token = $request->header('token');
        $uid = Tokens::where('token', '=', $token)->first();
        $usr = Users::where('id', $uid->id)->first();

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

        if ($branch) {
            Logs::create([
                'user_id' => $uid->id,
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
