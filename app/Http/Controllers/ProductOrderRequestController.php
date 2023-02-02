<?php

namespace App\Http\Controllers;

use App\Models\ProductOrderRequest;
use App\Models\WhsDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductOrderRequestController extends Controller
{
    public function warehouseview(Request $request)
    {
        if ($request->user()->cannot('viewAny', ProductOrderRequest::class)) {
            return response('Unauthorized', 401);
        }
        $wid       = WhsDetail::where('user_id', Auth::id())->first();
        $Orequests = ProductOrderRequest::where('warehouse_id', $wid->warehouse_id)
                                        ->orderByRaw("CASE status
                                            WHEN 'accepted' THEN 1
                                            WHEN 'sent' THEN 2
                                            WHEN 'transferred' THEN 3
                                            ELSE 4
                                            END")
                                        ->orderBy('request_date', 'desc')
                                        ->orderBy('product_code', 'asc')
                                            
                                        ->get();
        // if($Orequests->quantity) {
            // $Orequest = DB::table('product_order_requests')
                        // ->select()
        // }
        return response()->json($Orequests);
    }

    public function adminview(Request $request)
    {
        if ($request->user()->cannot('viewAny', ProductOrderRequest::class)) {
            return response('Unauthorized', 401);
        }
        $Orequests = ProductOrderRequest::orderBy('request_date', 'asc')
                                        ->orderBy('product_code', 'asc')
                                        // ->orderBy('status')
                                        ->get();
                                            
        // $status = ProductOrderRequest::where('status','sent')
        //                              ->update(['status' => 2]);

        return response()->json($Orequests);
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
        
        $token = Str::uuid()->toString();
        $product_code  = $request->input('product_code');
        $quantity      = $request->input('quantity');
        $wid           = WhsDetail::where('user_id', Auth::id())->first();
        $Orequest = ProductOrderRequest::create([
            'product_order_requests_id' => Str::uuid()->toString(),
            'warehouse_id'   => $wid->warehouse_id,
            'product_code'   => $product_code,
            'request_date'   => Carbon::now('Asia/Jakarta'),
            'quantity'       => $quantity,
        ]);

        return response()->json($Orequest);
    }

    public function adminedit(Request $request)
    {
        if ($request->user()->cannot('update', ProductOrderRequest::class)) {
            return response('Unauthorized', 401);
        }
        $validator = $this->validate($request, [
            'request_id'    => 'required',
            'status'        => 'required',
        ]);
        $status = intval($request->input('status'));
        $id = $request->request_id;

        $Orequest = ProductOrderRequest::where('product_order_requests_id', $id)
                                       ->update([
            'status'        => $status,
        ]);

        return response()->json($Orequest);
    }

    public function warehousedit(Request $request)
    {
        if ($request->user()->cannot('update', ProductOrderRequest::class)) {
            return response('Unauthorized', 401);
        }
        $validator = $this->validate($request, [
            'request_id'    => 'required',
            'product_code'  => 'required',
            'quantity'      => 'required'
        ]);
        $id = $request->request_id;
        $pcode = $request->input('product_code');
        $qu = $request->input('quantity');

        $Orequest = ProductOrderRequest::where('product_order_requests_id', $id)
                                       ->update([
            'product_code'  => $pcode,
            'quantity'      => $qu,
        ]);

        return response()->json('successfull');
    }

    public function showProduct(Request $request, $productCode)
    {
        if ($request->user()->cannot('view', Warehouse::class)&&$request->user()->cannot('viewAny', Warehouse::class)) {
            return response('Unauthorized', 401);
        }
        $Orequest = ProductOrderRequest::where('product_code', $productCode)
                                       ->whereIn('status', ['sent', 'accepted'])
                                       ->orderBy('request_date', 'desc')
                                       ->get(['product_order_requests_id','warehouse_id','request_date','quantity', 'status']);
        
        return response()->json($Orequest);
    }
}
