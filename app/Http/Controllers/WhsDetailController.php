<?php

namespace App\Http\Controllers;

use App\Models\Whs_Details;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WhsDetailController extends Controller
{
    public function store(Request $request)
    {
        $validator = $this->validate($request, [
            'user_id'       => 'required',
            'manager_name'  => 'required',
            'contact'       => 'required|max:15',
            'adress'        => 'required',
        ]);
        
        $uuid = Str::uuid()->toString();
        $whsdetail = Whs_Details::create([
            'warehouse_id' => $uuid,
            'user_id'  => $request->input('user_id'),
            'manager_name'  => $request->input('manager_name'),
            'contact'         => $request->input('contact'),
            'adress'    => $request->input('adress'),
        ]);
        
        // $uh = new UserHelper;
        // if ($warehouse) {
        //     Logs::create([
        //         'uid'       => $uh->getUserData($request->header('token'))->uid,
        //         'datetime'  => Carbon::now('Asia/Jakarta'),
        //         'activity'  => 'Product Request(s)',
        //         'detail'    => 'Branch "'.$branch_id.'" Requested Product "'.$product_code.'" with amount "'.$amount
        //     ]);
        //     return response()->json(['message' => 'Data added successfully'], 201);
        // }else {
        //     return response()->json("Failure");
        // }
        return response()->json($whsdetail);
    }
}
