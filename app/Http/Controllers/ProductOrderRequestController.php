<?php

namespace App\Http\Controllers;

use App\Models\ProductOrderRequest;
use App\Models\WhsDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductOrderRequestController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->can('vieww', ProductOrderRequest::class)) {
            $Orequests = ProductOrderRequest::whereNot('status', 'rejected')
                                            ->join('products', 'product_order_requests.product_code', '=', 'products.product_code')
                                            ->orderBy('request_date', 'asc')
                                            ->orderBy('product_code', 'asc')
                                            ->paginate(9, ['products.name', 'product_order_requests.*']);
            return response()->json($Orequests, 200);
        }elseif ($request->user()->can('viewAny', ProductOrderRequest::class)) {
            $wid       = WhsDetail::where('user_id', Auth::id())->first();
            $Orequests = ProductOrderRequest::where('warehouse_id', $wid->warehouse_id)
                                            ->join('products', 'product_order_requests.product_code', '=', 'products.product_code')
                                            ->orderBy('request_date', 'desc')
                                            ->orderBy('product_code', 'asc')   
                                            ->paginate(9, ['products.name', 'product_order_requests.*']);
            return response()->json($Orequests, 200);
        }else {
            return response('Unauthorized', 401);
        }
    }

    public function store(Request $request)
    {
        if ($request->user()->cannot('create', ProductOrderRequest::class)) {
            return response('Unauthorized', 401);
        }
        $validator = $this->validate($request, [
            'product_code' => 'required',
            'quantity'     => 'required',
        ]);
        
        $product_code  = $request->input('product_code');
        $quantity      = $request->input('quantity');
        $wid           = WhsDetail::where('user_id', Auth::id())->first();
        $check = ProductOrderRequest::where('product_code', $product_code)
            ->where('status', 'pending')
            ->where('warehouse_id', $wid->warehouse_id)
            ->first();

        if ($check) {
            return response()->json(['message' => 'Request has been exist', 'data' => ['product_code' => $product_code, 'quantity' => $quantity]], 400);
        }
        $Orequest = ProductOrderRequest::create([
            'product_order_requests_id' => Str::uuid()->toString(),
            'warehouse_id'   => $wid->warehouse_id,
            'product_code'   => $product_code,
            'request_date'   => Carbon::today('Asia/Jakarta')->toDateString(),
            'quantity'       => $quantity,
        ]);

        return response()->json(['message' => 'Request Created', 'data' => $Orequest], 201);
    }

    public function edit(Request $request)
    {
        if ($request->user()->cannot('updatew', ProductOrderRequest::class)) {
            return response('Unauthorized', 401);
        }
            $validator = $this->validate($request, [
                'product_order_requests_id' => 'required',
                'quantity'      => 'required'
            ]);
            $id = $request->input('product_order_requests_id');
            $pcode = $request->input('product_code');
            $qu = $request->input('quantity');
    
            $Orequest = ProductOrderRequest::where('product_order_requests_id', $id)
                                           ->update([
                'product_code'  => $pcode,
                'quantity'      => $qu,
            ]);
    
            return response()->json(['message' => 'Request Updated successfully', 'data' => $Orequest], 200);
        
    }

    public function showProduct(Request $request, $productCode)
    {
        if ($request->user()->cannot('view', ProductOrderRequest::class)) {
            return response('Unauthorized', 401);
        }
        $Orequest = ProductOrderRequest::where('product_code', $productCode)
                                       ->whereIn('status', ['pending', 'accepted'])
                                       ->orderBy('request_date', 'desc')
                                       ->join('whs_detail','product_order_requests.warehouse_id','=','whs_detail.warehouse_id')
                                       ->get(['product_order_requests_id','product_order_requests.warehouse_id','request_date','quantity', 'status', 'name']);
        
        return response()->json($Orequest);
    }

    public function decline(Request $request)
    {
        if ($request->user()->cannot('update', ProductOrderRequest::class)) {
            return response('Unauthorized', 401);
        }
        $id = $request->input('product_order_requests_id');
        $a = ProductOrderRequest::where('product_order_requests_id', $id)
                           ->update(['status' => 4]);
        return response()->json(['message' => 'Request Rejected']);
    }

    public function accept(Request $request)
    {
        if ($request->user()->cannot('update', ProductOrderRequest::class)) {
            return response('Unauthorized', 401);
        }
        $id = $request->input('product_order_requests_id');
        $a = ProductOrderRequest::where('product_order_requests_id', $id)
                           ->update(['status' => 2]);
        return response()->json(['message' => 'Request Accepted']);
    }
}
