<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\WarehouseResponseBranch;
use App\Models\WhsDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isEmpty;

class WarehouseResponseBranchController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->cannot('viewAny', ProductOrder::class)) {
            return response('Unauthorized', 401);
        }
        $wrespons = WarehouseResponseBranch::paginate(9);
        
        return response()->json($wrespons);
    }

    public function store(Request $request)
    {
        if ($request->user()->cannot('create', ProductOrder::class)) {
            return response('Unauthorized', 401);
        }
        $validator = $this->validate($request, [ 
            'warehouse_id'  => 'required',
            'branch_id'     => 'required',
            'product_code'  => 'required',
            'send_date'     => 'required',
            'quantity'      => 'required',
            
        ]);
        
        $branch_id   = $request->input('branch_id');
        $product_code  = $request->input('product_code');
        $send_date = $request->input('send_date');
        $total_amount  = $request->input('total_amount');
        $quantity      = $request->input('quantity');
        $wid = WhsDetail::where('user_id', Auth::Id())->first();

        $order = WarehouseResponseBranch::create([
            'warehouse_response_id' => Str::uuid()->toString(),
            'warehouse_id'          => $wid->warehouse_id,
            'branch_id'             => $branch_id,
            'product_code'          => $product_code,
            'send_date'             => isEmpty($send_date) ? Carbon::today('Asia/Jakarta')->toDateString() : $send_date,
            'quantity'              => $quantity,
        ]);

        return response()->json(['message' => 'Product Sent','data' => $order], 201);
    }

    }
