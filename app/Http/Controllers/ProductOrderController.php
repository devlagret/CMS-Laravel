<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use App\Models\ProductOrderRequest;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductOrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->cannot('viewAny', ProductOrderRequest::class)) {
            return response('Unauthorized', 401);
        }
        $stockups = ProductOrderRequest::get();
        
        return response()->json($stockups);
    }

    public function store(Request $request)
    {
        if ($request->user()->cannot('create', ProductOrderRequest::class)) {
            return response('Unauthorized', 401);
        }
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

        $quan = ProductOrderRequest::where('status', 'accepted')
                                   ->where('product_code', $product_code)
                                   ->groupBy('warehouse_id')
                                   ->selectRaw('sum(quantity) as sum, warehouse_id')
                                   ->get(['sum', 'warehouse_id']);

        $stock = [];
        $wid = [];
        $num_i = 0;
        foreach ($quan as $value) {
            $stock[] = $value['sum'];
            $wid[] = $value['warehouse_id'];
            $stockup = Warehouse::where('product_code', $product_code)
                                ->whereIn('warehouse_id', $wid)
                                ->increment('stock', $stock[$num_i]);
                                // ->get('stock')
                                
            $num_i++;
        }
        // $stockup = "1";
                            
        // $stockup->stock += $stock;
        // $stockup->save();

        return response()->json($quan);
    }
}
