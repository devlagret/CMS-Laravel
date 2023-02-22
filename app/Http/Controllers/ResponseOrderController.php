<?php

namespace App\Http\Controllers;

use App\Models\ProductOrderRequest;
use App\Models\ResponseOrder;
use App\Models\WhsDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if ($response->product_order_requests_id != '') {
            $check = ProductOrderRequest::where('warehouse_id', $wid->warehouse_id)
                                        ->where('product_order_requests_id', $response->product_order_requests_id)
                                        ->first();
            return response()->json($check);
            // return response()->json($response->product_order_requests_id);
        }
        return response()->json($response->product_order_requests_id);

    }
}
