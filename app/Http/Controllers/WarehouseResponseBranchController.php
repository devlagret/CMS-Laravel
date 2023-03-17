<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\ProductRequest;
use App\Models\Warehouse;
use App\Models\WarehouseResponseBranch;
use App\Models\WhsDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class WarehouseResponseBranchController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->cannot('viewAny', WarehouseResponseBranch::class)) {
            return response('Unauthorized', 401);
        }
        $wid = WhsDetail::where('user_id', Auth::Id())->first();
        $wrespons = WarehouseResponseBranch::where('warehouse_id', $wid->warehouse_id)
        ->join('products', 'warehouse_response_branches.product_code', '=', 'products.product_code')
        ->paginate(9, ['products.name', 'warehouse_response_branches.*']);
        
        return response()->json($wrespons);
    }

    public function store(Request $request)
    {
        if ($request->user()->cannot('create', WarehouseResponseBranch::class)) {
            return response('Unauthorized', 401);
        }
        $validator = $this->validate($request, [ 
            'request_id'    => 'required',
            'batch_id'    => 'required',
        ]);
        
        $send_date = $request->input('send_date');
        $bid = $request->input('batch_id');
        $rid  = $request->input('request_id');
        $detail  = ProductRequest::where('request_id', $rid)->first();
        $wid = WhsDetail::where('user_id', Auth::Id())->first();
        if ($send_date == '') {
            $send_date = Carbon::today('Asia/Jakarta')->toDateString();
        }

        $wrespon = WarehouseResponseBranch::create([
            'warehouse_response_id' => Str::uuid()->toString(),
            'warehouse_id'          => $wid->warehouse_id,
            'branch_id'             => $detail->branch_id,
            'request_id'            => $rid,
            'product_code'          => $detail->product_code,
            'send_date'             => $send_date,
            'quantity'              => $detail->amount,
        ]);
        if (!$wrespon) {
            return response()->json(['message' => 'Failed to Proccess','data' => $wrespon], 400);
        }else {
            $accept = Batch::where('batch_id', $bid)
                     ->decrement('stock', $detail->amount);
            if ($accept) {
                ProductRequest::where('request_id', $rid)
                ->update(['status' => 3]);
            }
            return response()->json(['message' => 'Product Sent','data' => $wrespon], 201);
        }
    }

    public function viewResponse(Request $request)
    {
        if ($request->user()->cannot('viewAny', WarehouseResponseBranch::class)) {
            return response('Unauthorized', 401);
        }
        $wrespons = WarehouseResponseBranch::paginate(9);
        
        return response()->json($wrespons);
    }

    public function getResponse(Request $request, $request_id)
    {
        if ($request->user()->cannot('checkRoleB', WarehouseResponseBranch::class)) {
            return response('Unauthorized', 401);
        }
        // $request_id = $request->input('request_id');

        $wrespons = WarehouseResponseBranch::where('request_id', $request_id)->first();
        
        return response()->json($wrespons->warehouse_response_id);
    }
}


