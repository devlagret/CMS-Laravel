<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\ProductOrder;
use App\Models\ProductOrderRequest;
use App\Models\ResponseOrder;
use App\Models\Warehouse;
use App\Models\WhsDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class ResponseOrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->can('view', ResponseOrder::class)) {
            $response = ResponseOrder::join('product_order_requests','product_order_requests.product_order_requests_id','=','response_orders.product_order_requests_id')
                                     ->paginate(9, ['product_order_requests.*', 'response_orders.is_received', 'response_orders.response_id']);
            return response()->json($response, 201);
        } elseif ($request->user()->can('viewAny', ResponseOrder::class)) {
            $wid = WhsDetail::where('user_id', Auth::id())->first();
            $response = ResponseOrder::where('response_orders.warehouse_id', $wid->warehouse_id)
                                     ->join('product_order_requests','product_order_requests.product_order_requests_id','=','response_orders.product_order_requests_id')
                                     ->paginate(9, ['product_order_requests.*', 'response_orders.is_received', 'response_orders.response_id']);
            return response()->json($response, 201);
        } else {
            return response('Unauthorized', 401);
        }
    }

    // Warehouse Accept Response(Add Batch)
    public function accept(Request $request)
    {
        $scan = $request->input('response_id');
        $wid = WhsDetail::where('user_id', Auth::id())->first();
        $response = ResponseOrder::where('response_id', $scan)
                                 ->whereNot('status', 'Finished')
                                 ->first();
        if ($response) {
            $expd = ProductOrder::where('product_order_id', $response->product_order_id)
                                ->first();
            $check = ResponseOrder::where('response_id', $scan)
                                  ->where('is_received', 'Accepted')
                                  ->first();
            if ($check) {
                $pc = ProductOrderRequest::where('product_order_requests_id', $response->product_order_requests_id)
                                         ->first();
                $bc = Batch::where('warehouse_id', $wid->warehouse_id)
                           ->where('product_code', $pc->product_code)
                           ->where('exp_date', $expd->product_expired)
                           ->exists();
                if ($bc) {
                    Batch::where('warehouse_id', $wid->warehouse_id)
                        ->where('product_code', $pc->product_code)
                        ->where('exp_date', $expd->product_expired)
                        ->increment('stock', $response->quantity);
                    ResponseOrder::where('response_id',$scan)->update(['status' => 'Finished']);
                    return response()->json(['message' => 'Stock Increase cause product is exist'], 200);
                }else {
                    $batch = Batch::create([
                        'batch_id'     => Str::uuid()->toString(),
                        'warehouse_id' => $wid->warehouse_id,
                        'product_code' => $pc->product_code,
                        'stock'        => $response->quantity,
                        'exp_date'     => $expd->product_expired,
                        'entry_date'   => Carbon::today('Asia/Jakarta')->toDateString(),
                    ]);
                    $ch = Warehouse::where('warehouse_id', $wid->warehouse_id)
                    ->where('product_code', $pc->product_code)->exists();
                    if(!$ch){
                        $w = Warehouse::create([
                            'warehouse_id'  => $wid->warehouse_id,
                            'product_code'  => $pc->product_code,
                            'stock'         => $response->quantity,
                            'entry_date'    => Carbon::today()->toDateString(),
                            'location'      => $wid->adress,
                        ]);
                        return response()->json(['message' => 'Product Added to Inventory','data' => $w], 201);
                    }
                    ResponseOrder::where('response_id',$scan)->update(['status' => 'Finished']);
                    ProductOrderRequest::where('product_order_requests_id',$response->product_order_requests_id);
                    return response()->json(['message' => 'Batch Saved','data' => $ch], 201);
                }
            }
            return response()->json(['message' => 'Product is Still On The Way']);
        }
        return response()->json(['message' => 'This Response Already Received by ']);
        // return response()->json($scan);
    }

    public function position(Request $request)
    {
        $scan = $request->input('response_id');
        $response = ResponseOrder::where('response_id', $scan)
                                 ->update(['is_received' => 'Accepted']);
    }

    public function test(Request $request)
    {
        // $uuid = '1968ec4a-2a73-11df-9aca-00012e27a270';

        // $binaryUuid = hex2bin(str_replace('-', '', $uuid));
        // return response()->json($binaryUuid);
        $batches = Batch::selectRaw('batches.*, SUM(stock) as total, products.name')
        ->groupBy('batches.product_code', 'status', 'exp_date')
        ->join('products', 'batches.product_code','=','products.product_code')
        ->get(['batches.*', 'products.name']);
        
        return response()->json($batches);
    }
}
