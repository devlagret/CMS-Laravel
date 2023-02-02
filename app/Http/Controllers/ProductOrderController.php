<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\ProductOrder;
use App\Models\RequestOrder;
use App\Models\User;
use App\Models\ProductOrderRequest;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use function PHPUnit\Framework\isEmpty;

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
        // if ($request->user()->cannot('create', ProductOrderRequest::class)) {
        //     return response('Unauthorized', 401);
        // }
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

        $order = ProductOrder::create([
                'product_order_id'=> Str::uuid()->toString(),
                'supplier_id'    => $supllier_id,
                'product_code'   => $product_code,
                'purchase_date'  => isEmpty($purchase_date) ? Carbon::today('Asia/Jakarta')->toDateString() : $purchase_date,
                'total_amount'   => $total_amount,
                'quantity'       => $quantity,
        ]);
        
        // $stock = [];
        // $wid = [];
        // foreach ($quan as $value) {
        //     $stock[] = $value['sum'];
        //     $wid[] = $value['warehouse_id'];
        // }
        // $q = array_sum($stock);

        // if (($quantity - $q) >= 0) {
        //     $remain = $quantity - $q;
        //     if ($remain > 0) {

        //         $nwid = $request->input('warehouse_id');
        //         $qu = $request->input('quantity1');
        //         do {
        //             if ($remain - $qu >0) {
        //                 return $this->addstock($nwid, $qu, $product_code);
        //             }
        //             $remain = $remain - $qu;
        //         } while ($remain >= 0);
        //     }
        //     return response()->json('Data Added');
        // } else {
        //     return response()->json('Quantity Kurang');
        // }

        // for ($i=0; $i < count($wid); $i++) { 
        //     $stockup = Warehouse::where('product_code', $product_code)
        //             ->where('warehouse_id', $wid[$i])
        //                 ->increment('stock', $stock[$i]);
        // }
    }

    public function distribute(Request $request)
    {
        if ($request->user()->cannot('create', ProductOrderRequest::class)) {
            return response('Unauthorized', 401);
        }
        $validator = $this->validate($request, [
            'quantity'     => 'required',
            'warehouse_id' => 'required',
        ]);

        $poid = ProductOrder::latest()->first();
        $quantity = explode(',', $request['quantity']);
        $wid = explode(',', $request['warehouse_id']);
        $porid = explode(',', $request['product_order_requests_id']);
        for ($i=0; $i < count($porid); $i++) {
            $wid[$i];
            if ($porid[$i] == ' ') {
                RequestOrder::firstOrCreate([
                    'product_order_id' => $poid->product_order_id,
                    'warehouse_id' => $wid[$i],
                    'quantity' => $quantity[$i],
                ]);
            }else {
                RequestOrder::firstOrCreate([
                    'product_order_id' => $poid->product_order_id,
                    'product_order_requests_id' => $porid[$i],
                    'warehouse_id' => $wid[$i],
                    'quantity' => $quantity[$i],
                ]);
            }
            
        }

        // $addstock = Warehouse::where('product_code', $product_code)
        //                             ->where('warehouse_id', $wid)
        //                             ->increament('stock', $stock);

        // return response()->json($wid);
    }
}
