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
    public function view(Request $request)
    {
        if ($request->user()->can('vieww', ProductOrderRequest::class)) {
            $Orequests = ProductOrderRequest::orderBy('request_date', 'asc')
                                            ->orderBy('product_code', 'asc')
                                            ->get()
                                            ->simplePaginate(10);
            return response()->json($Orequests);
        }elseif ($request->user()->can('viewAny', ProductOrderRequest::class)) {
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
            return response()->json($Orequests);
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
        
        $token = Str::uuid()->toString();
        $product_code  = $request->input('product_code');
        $quantity      = $request->input('quantity');
        $wid           = WhsDetail::where('user_id', Auth::id())->first();
        $Orequest = ProductOrderRequest::create([
            'product_order_requests_id' => Str::uuid()->toString(),
            'warehouse_id'   => $wid->warehouse_id,
            'product_code'   => $product_code,
            'request_date'   => Carbon::today('Asia/Jakarta')->toDateString(),
            'quantity'       => $quantity,
        ]);

        return response()->json($Orequest);
    }

    public function edit(Request $request)
    {
        if ($request->user()->can('update', ProductOrderRequest::class)) {
            $validator = $this->validate($request, [
                'request_id'    => 'required',
                'status'        => 'required',
            ]);
            $status = intval($request->input('status'));
            $id = $request->request_id;
    
            $Orequest = ProductOrderRequest::where('product_order_requests_id', $id)
                                           ->update([
                'status' => $status,
            ]);
            return response()->json($Orequest);
        }elseif ($request->user()->can('updatew', ProductOrderRequest::class)) {
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
        }else {
            return response('Unauthorized', 401);
        }
    }

    public function showProduct(Request $request, $productCode)
    {
        if ($request->user()->cannot('vieww', Warehouse::class)&&$request->user()->cannot('viewAny', Warehouse::class)) {
            return response('Unauthorized', 401);
        }
        $Orequest = ProductOrderRequest::where('product_code', $productCode)
                                       ->whereIn('status', ['sent', 'accepted'])
                                       ->orderBy('request_date', 'desc')
                                       ->get(['product_order_requests_id','warehouse_id','request_date','quantity', 'status']);
        
        return response()->json($Orequest);
    }
}
