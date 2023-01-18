<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;
use App\Models\Product_Requests;
use App\Models\Tokens;
use App\Models\Users;
use App\Models\Logs;
use Carbon\Carbon;
use App\Helpers\UserHelper;

class ProductRequestsController extends Controller
{
    protected  $uh = new UserHelper;
    public function index()
    {
        $product_reqs = Product_Requests::get();
        
        return response()->json($product_reqs);
    }

    
    public function store(Request $request)
    {
        $validator = $this->validate($request, [
            'branch_id'    => 'required',
            'product_code'    => 'required',
            'amount'        => 'required|max:15',
            'order_date'        => 'required',
            'out_date'        => 'required',
            'status'        => 'required',
        ]);
        $branch_id = $request->input('branch_id');
        $product_code = $request->input('product_code');
        $amount = $request->input('amount');
        $order_date = $request->input('order_date');
        $out_date = $request->input('out_date');
        $status = $request->input('status');
        
        $product_req = Product_Requests::create([
            'branch_id'    => $branch_id,
            'product_code'    => $product_code,
            'amount'    => $amount,
            'order_date'    => $order_date,
            'out_date'    => $out_date,
            'status'    => $status,
        ]);

        if ($product_req) {
            Logs::create([
                'user_id' => $this->uh->getUserData($request->header('token'))->uid,
                'datetime' => Carbon::now('Asia/Jakarta'),
                'activity' => 'Product Request(s)',
                'detail' => 'Branch "'.$branch_id.'" Requested Product "'.$product_code.'" with amount "'.$amount
            ]);
            return response()->json(['message' => 'Data added successfully'], 201);
        }else {
            return response()->json("Failure");
        }

        return response()->json($product_req);
    }

    
    public function show($id)
    {
        $product_req = Product_Requests::find($id);
        return response()->json($product_req);
    }

    public function update(Request $request, $id)
    {
        $validator = $this->validate($request, [
            'branch_id'    => 'required',
            'product_code' => 'required',
            'amount'       => 'required',
            'order_date'   => 'required',
            'out_date'     => 'required',
            'status'       => 'required',
        ]);
        $branch_id = $request->input('branch_id');
        $product_code = $request->input('product_code');
        $amount = $request->input('amount');

        $product_req = Product_Requests::whereId($id)->update([
            'branch_id'       => $request->input('branch_id'),
            'product_code'    => $request->input('product_code'),
            'amount'          => $request->input('amount'),
            'order_date'      => $request->input('order_date'),
            'out_date'        => $request->input('out_date'),
            'status'          => $request->input('status'),
        ]);

        if ($product_req) {
            Logs::create([
                'user_id' => $this->uh->getUserData($request->header('token'))->uid,
                'datetime' => Carbon::now('Asia/Jakarta'),
                'activity' => 'Product Request(s)',
                'detail' => 'Branch "'.$branch_id.'" Requested Product "'.$product_code.'" with amount "'.$amount
            ]);
            return response()->json(['message' => 'Data added successfully'], 201);
        }else {
            return response()->json("Failure");
        }
    }

    
    public function destroy($id)
    {
        Product_Requests::destroy($id);

        return response()->json(['message' => 'Deleted']);
    }
}
