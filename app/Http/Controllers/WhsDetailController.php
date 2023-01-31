<?php

namespace App\Http\Controllers;


use App\Models\WhsDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WhsDetailController extends Controller
{
    public function store(Request $request)
    {
        if ($request->user()->cannot('create', WhsDetail::class)) {
            return response('Unauthorized', 401);
        }
        $validator = $this->validate($request, [
            'manager_name'  => 'required',
            'contact'       => 'required|max:15',
            'adress'        => 'required',
        ]);
        
        $uuid = Str::uuid()->toString();
        $whsdetail = WhsDetail::create([
            'warehouse_id'  => $uuid,
            'user_id'       => Auth::id(),
            'manager_name'  => $request->input('manager_name'),
            'contact'       => $request->input('contact'),
            'adress'    => $request->input('adress'),
        ]);
        
        // $uh = new UserHelper;
        // if ($warehouse) {
        //     Log::create([
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
