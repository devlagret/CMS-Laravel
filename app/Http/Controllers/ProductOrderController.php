<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Token;
use App\Models\User;
use App\Models\ProductOrder;
use App\Models\ProductOrderRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductOrderController extends Controller
{
    public function index()
    {
        $stockups = ProductOrderRequest::get();
        
        return response()->json($stockups);
    }

    public function store(Request $request)
    {
        $validator = $this->validate($request, [
            
            'supplier_id'    => 'required',
            'product_code'   => 'required',
            'purchase_date'  => 'required',
            'total_amont'    => 'required',
            'quantity'       => 'required',
        ]);
        
        $supllier_id   = $request->input('supplier_id');
        $product_code  = $request->input('product_code');
        $purchase_date = $request->input('purchase_date');
        $total_amount  = $request->input('total_amount');
        $quantity      = $request->input('quantity');

        $order = ProductOrder::create([
            'supplier_id'    => $supllier_id,
            'product_code'   => $product_code,
            'purchase_date'  => $purchase_date,
            'total_amount'   => $total_amount,
            'quantity'       => $quantity,
        ]);

        

        // if ($category) {
        //     Log::create([
        //         'uid'   => $uid->id,
        //         'datetime'  => Carbon::now('Asia/Jakarta'),
        //         'activity'  => 'Add Category(s)',
        //         'detail'    => 'Add Category with type "'.$category_type.'" named "'.$category_name
        //     ]);
        //     return response()->json(['message' => 'Data added successfully'], 201);
        // }else {
        //     return response()->json("Failure");
        // }
    }
}
