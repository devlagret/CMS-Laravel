<?php

namespace App\Http\Controllers;

use App\Models\Product_Order_Request;
use App\Models\Whs_Details;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductOrderRequestController extends Controller
{
    public function index()
    {
        $products = Product_Order_Request::get();
        $user = Auth::check();
        return response()->json([$user,$products]);
    }

    public function store(Request $request)
    {
        $validator = $this->validate($request, [
            'product_code'   => 'required',
            'quantity'       => 'required',
        ]);
        
        $product_code  = $request->input('product_code');
        $quantity      = $request->input('quantity');
        $wid = Whs_Details::where('user_id', Auth::id());
        $p_order_req = Product_Order_Request::create([
            'warehouse_id'   => $wid->warehouse_id,
            'product_code'   => $product_code,
            'request_date'   => Carbon::now('Asia/Jakarta'),
            'quantity'       => $quantity,
        ]);

        return response()->json($p_order_req);
    }
}
