<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Token;
use App\Models\User;
use App\Models\ProductOrder;
use App\Models\ProductOrderRequest;
use App\Models\Warehouse;
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
            'total_amount'   => 'required',
            'quantity'       => 'required',
        ]);
        
        $supllier_id   = $request->input('supplier_id');
        $product_code  = $request->input('product_code');
        $purchase_date = $request->input('purchase_date');
        $total_amount  = $request->input('total_amount');
        $quantity      = $request->input('quantity');

        // $order = ProductOrder::create([
        //     'supplier_id'    => $supllier_id,
        //     'product_code'   => $product_code,
        //     'purchase_date'  => is_null($purchase_date) ? Carbon::now('Asia/Jakarta') : $purchase_date,
        //     'total_amount'   => $total_amount,
        //     'quantity'       => $quantity,
        // ]);
        
        $id = ProductOrderRequest::where('status', 'sent')
                                 ->where('product_code', $product_code)
                                //  ->groupBy('product_order_requests_id')
                                 ->get('product_order_requests_id');

        $quan = ProductOrderRequest::where('status', 'sent')
                                   ->where('product_code', $product_code)
                                //    ->groupBy('product_order_requests_id')
                                   ->get(['quantity', 'warehouse_id']);

        $stock = [];
        $wid = [];
        foreach ($quan as $value) {
            $stock[] = $value['quantity'];
            $wid[] = $value['warehouse_id'];
        }

        $stockup = Warehouse::whereIn('warehouse_id', $wid)
                            ->where('product_code', $product_code);
                            
        // $stockup->stock += $stock;

        return response()->json($stockup);
    }
}
