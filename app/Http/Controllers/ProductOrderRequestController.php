<?php

namespace App\Http\Controllers;

use App\Models\Product_Order_Request;
use App\Models\Whs_Details;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductOrderRequestController extends Controller
{
    public function warehouseview()
    {
        $wid       = Whs_Details::where('user_id', Auth::id())->first();
        $Orequests = Product_Order_Request::where('warehouse_id', $wid->warehouse_id)
                                            ->orderBy('request_date', 'desc')
                                            ->orderBy('product_code', 'asc')
                                            // ->orderBy('status')
                                            ->get();
        // if($Orequests->quantity) {
            // $Orequest = DB::table('product_order_requests')
                        // ->select()
        // }
        return response()->json($Orequests);
    }

    public function adminview()
    {
        $Orequests = Product_Order_Request::orderBy('request_date', 'asc')
                                            ->orderBy('product_code', 'asc')
                                            // ->orderBy('status')
                                            ->get();
    }

    public function store(Request $request)
    {
        $validator = $this->validate($request, [
            'product_code'   => 'required',
            'quantity'       => 'required',
        ]);
        
        $token = Str::uuid()->toString();
        $product_code  = $request->input('product_code');
        $quantity      = $request->input('quantity');
        $wid           = Whs_Details::where('user_id', Auth::id())->first();
        $Orequest = Product_Order_Request::create([
            'product_order_requests_id' => Str::uuid()->toString(),
            'warehouse_id'   => $wid->warehouse_id,
            'product_code'   => $product_code,
            'request_date'   => Carbon::now('Asia/Jakarta'),
            'quantity'       => $quantity,
        ]);

        return response()->json($Orequest);
    }
}
