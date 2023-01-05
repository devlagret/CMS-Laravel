<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product_Requests;
use Illuminate\Contracts\Validation\Validator;

class ProductRequestsController extends Controller
{
    public function index()
    {
        $product_reqs = Product_Requests::get();
        
        return response()->json($product_reqs);
    }

    
    public function store(Request $request)
    {
        $product_req = new Product_Requests;
        $product_req->branch_id = $request->branch_id;
        $product_req->product_code = $request->product_code;
        $product_req->amount = $request->amount;
        $product_req->order_date = $request->order_date;
        $product_req->out_date = $request->out_date;
        $product_req->status = $request->status;
        $product_req->save();

        return response()->json($product_req);
    }

    
    public function show($id)
    {
        $product_req = Product_Requests::find($id);

        return response()->json($product_req);
    }

    public function update(Request $request, $id)
    {
        // $product_req = product_request::find($id);
        // $product_req = new product_request;
        // $product_req->branch_id = $request->branch_id;
        // $product_req->product_code = $request->product_code;
        // $product_req->amount = $request->amount;
        // $product_req->order_date = $request->order_date;
        // $product_req->out_date = $request->out_date;
        // $product_req->status = $request->status;
        // $product_req->save();

        $validator = $this->validate($request, [
            'branch_id'    => 'required',
            'product_code' => 'required',
            'amount'       => 'required',
            'order_date'   => 'required',
            'out_date'     => 'required',
            'status'       => 'required',
        ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         ''
        //     ]);
        // } else {
        //     # code...
        // }

        $product_req = Product_Requests::whereId($id)->update([
            'branch_id'       => $request->input('branch_id'),
            'product_code'    => $request->input('product_code'),
            'amount'          => $request->input('amount'),
            'order_date'      => $request->input('order_date'),
            'out_date'        => $request->input('out_date'),
            'status'          => $request->input('status'),
        ]);

        return response()->json($product_req);
    }

    
    public function destroy($id)
    {
        Product_Requests::destroy($id);

        return response()->json(['message' => 'Deleted']);
    }
}
