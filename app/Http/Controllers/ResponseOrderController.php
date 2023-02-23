<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\ProductOrder;
use App\Models\ProductOrderRequest;
use App\Models\ResponseOrder;
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
        $wid = WhsDetail::where('user_id', Auth::id())->first();
        $response = ResponseOrder::where('warehouse_id', $wid->warehouse_id)
                                        ->paginate(9);
        return response()->json($response);
    }

    public function accept(Request $request)
    {
        $scan = $request->input('code');
        $wid = WhsDetail::where('user_id', Auth::id())->first();
        $response = ResponseOrder::where('response_id', $scan)
                                        ->first();
        $expd = ProductOrder::where('product_order_id', $response->product_order_id)
                            ->first();
        if ($response) {
            $check = ProductOrderRequest::where('warehouse_id', $wid->warehouse_id)
                                        ->where('product_order_requests_id', $response->product_order_requests_id)
                                        ->exists();
            if ($check) {
                $pc = ProductOrderRequest::where('product_order_requests_id', $response->product_order_requests_id)
                                         ->first();
                $ba = Batch::where('warehouse_id', $wid->warehouse_id)
                           ->where('product_code', $pc)
                           ->where('exp_date', $expd->product_expired)
                           ->exists();
                if ($ba) {
                    Batch::where('warehouse_id', $wid->warehouse_id)
                        ->where('product_code', $pc)
                        ->where('exp_date', $expd->product_expired)
                        ->increment('stock', $response->quantity);
                    return response()->json(['message' => 'Stock Increase cause product is exist'], 200);
                }else {
                    $batch = Batch::create([
                        'batch_id'     => Str::uuid()->toString(),
                        'warehouse_id' => $wid->warehouse_id,
                        'product_code' => $pc,
                        'stock'        => $response->quantity,
                        'exp_date'     => $expd->product_expired,
                        'entry_date'   => Carbon::today('Asia/Jakarta')->toDateString(),
                    ]);
                    return response()->json(['message' => 'Product Saved','data' => $batch], 201);
                }
            }
            return response()->json(['message' => 'This Batch is Not the Product You Requested']);
        }
        return response()->json(['message' => 'Code Is Not Valid']);

    }
}
