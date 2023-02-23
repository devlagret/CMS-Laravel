<?php

namespace App\Http\Controllers;

use App\Models\ProductOrder;
use App\Models\ResponseOrder;
use App\Models\ProductOrderRequest;
use App\Models\SendedProduct;
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
        $stockups = ProductOrder::orderBy('expire_date', 'asc')->paginate(9);
        
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
            'expire_date'    => 'required',
        ]);
        $supllier_id   = $request->input('supplier_id');
        $pc  = $request->input('product_code');
        $purchase_date = $request->input('purchase_date');
        $total_amount  = $request->input('total_amount');
        $quantity      = $request->input('quantity');
        $exp           = $request->input('expire_date');
        
        $check = ProductOrder::where('product_code', $pc)
                      ->where('expire_date', $exp)
                      ->exists();

        if ($check) {
            ProductOrder::where('product_code', $pc)
                ->where('expire_date', $exp)
                ->increment('quantity', $quantity);
            return response()->json(['message' => 'Stock Increase cause ordered product still exist'], 200);
        }else {
            $order = ProductOrder::create([
                'product_order_id'=> Str::uuid()->toString(),
                'supplier_id'    => $supllier_id,
                'product_code'   => $pc,
                'purchase_date'  => isEmpty($purchase_date) ? Carbon::today('Asia/Jakarta')->toDateString() : $purchase_date,
                'total_amount'   => $total_amount,
                'quantity'       => $quantity,
                'product_expired'=> $exp,
            ]);
            return response()->json(['message' => 'Product Saved','data' => $order], 201);
        }
    }

    public function distribute(Request $request, $orderid)
    {
        if ($request->user()->cannot('create', ProductOrderRequest::class)) {
            return response('Unauthorized', 401);
        }
        $poid = ProductOrder::where('product_order_id', $orderid)->first();

        $quantity = $request->input('quantity');
        $wid = $request->input('warehouse_id');
        $porid = $request->input('product_order_requests_id');
        
        if ($poid->quantity > $quantity) {
            $in = ResponseOrder::Create([
                'response_id'               => Str::uuid()->toString(),
                'product_order_id'          => $poid->product_order_id,
                'product_order_requests_id' => $porid,
                'warehouse_id'              => $wid,
                'quantity'                  => $quantity,
            ]);
            if ($in) {
                ProductOrderRequest::where('product_order_requests_id', $porid)
                                   ->update(['status' => 'transferred']);
                ProductOrder::where('product_order_id', $orderid)
                                    ->decrement('quantity', $quantity);
                return response()->json(['message' => 'Requested Product Ready to Transfer']);
            }
        }
        return response()->json([
            'ordered quantity' => $poid->quantity,
            'requested quantity' => $quantity,
            'message' => 'the product ordered is less than the request'], 400);
    }
}
