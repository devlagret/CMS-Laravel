<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\Tokens;
use App\Models\User;
use App\Models\Product_Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductOrderController extends Controller
{
    public function index()
    {
        $stockups = Product_Order::get();
  
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

        $category = Product_Order::create([
        
            'supplier_id'    => $supllier_id,
            'product_code'   => $product_code,
            'purchase_date'  => $purchase_date,
            'total_amont'    => $total_amount,
            'quantity'       => $quantity,
        ]);

        // if ($category) {
        //     Logs::create([
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
