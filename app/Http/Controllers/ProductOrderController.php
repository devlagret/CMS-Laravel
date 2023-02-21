<?php

namespace App\Http\Controllers;

use App\Models\ProductOrder;
use App\Models\RequestOrder;
use App\Models\ProductOrderRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use function PHPUnit\Framework\isEmpty;

class ProductOrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->cannot('viewAny', ProductOrder::class)) {
            return response('Unauthorized', 401);
        }
        $stockups = ProductOrder::paginate(9);
        
        return response()->json($stockups);
    }

    public function store(Request $request)
    {
        if ($request->user()->cannot('create', ProductOrder::class)) {
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

        $order = ProductOrder::create([
            'product_order_id'=> Str::uuid()->toString(),
            'supplier_id'    => $supllier_id,
            'product_code'   => $product_code,
            'purchase_date'  => isEmpty($purchase_date) ? Carbon::today('Asia/Jakarta')->toDateString() : $purchase_date,
            'total_amount'   => $total_amount,
            'quantity'       => $quantity,
        ]);

        return response()->json(['message' => 'Data Added Succesfully','data' => $order], 201);
    }

    public function distribute(Request $request, $orderid)
    {
        if ($request->user()->cannot('create', ProductOrderRequest::class)) {
            return response('Unauthorized', 401);
        }
        $validator = $this->validate($request, [
            'quantity'     => 'required',
            'warehouse_id' => 'required',
        ]);

        $poid = ProductOrder::where('product_order_id', $orderid)->first();

        $quantity = explode(',', $request['quantity']);
        $wid = explode(',', $request['warehouse_id']);
        $porid = explode(',', $request['product_order_requests_id']);
        if (array_sum($quantity) > $poid->quantity) {
            return response()->json([
                'distribute quantity' => array_sum($quantity),
                'quantity ordered' => $poid->quantity,
                'message' => 'Please decrease the distribute quantity']);
        } else {
            for ($i=0; $i < count($porid); $i++) {
                if ($porid[$i] == ' ') {
                    RequestOrder::firstOrCreate([
                        'product_order_id' => $poid->product_order_id,
                        'warehouse_id' => $wid[$i],
                        'quantity' => $quantity[$i],
                    ]);
                }else {
                    $in = RequestOrder::firstOrCreate([
                        'product_order_id' => $poid->product_order_id,
                        'product_order_requests_id' => $porid[$i],
                        'warehouse_id' => $wid[$i],
                        'quantity' => $quantity[$i],
                    ]);
                    if ($in) {
                        ProductOrderRequest::where('product_order_requests_id', $porid[$i])
                                            ->update(['status' => 'transferred']);
                    }
                }
            }
        }
    }
}
