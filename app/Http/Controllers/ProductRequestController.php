<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;
use App\Models\ProductRequest;
use App\Models\Token;
use App\Models\User;
use App\Models\Log;
use Carbon\Carbon;
use App\Helpers\UserHelper;
use App\Models\Branch;
use App\Models\Warehouse;
use App\Models\WhsDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductRequestController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->user()->can('vieww', ProductRequest::class)) {
            $wid = WhsDetail::where('user_id', Auth::id())->first();
            $product_reqs = ProductRequest::where('warehouse_id', $wid->warehouse_id)
                                            ->orderBy('order_date', 'asc')
                                            ->orderBy('product_code', 'asc')
                                            ->exists();
            if (!$product_reqs) {
                return response()->json('Tidak Ada Request Produk', 200);
            }
            $product_reqs = ProductRequest::where('warehouse_id', $wid->warehouse_id)
                                            ->join('products', 'product_requests.product_code', '=', 'products.product_code')
                                            ->orderBy('order_date', 'asc')
                                            ->orderBy('product_code', 'asc')
                                            ->paginate(9, ['products.name', 'product_requests.*']);
            return response()->json($product_reqs, 200);
        }elseif ($request->user()->can('viewAny', ProductRequest::class)) {
            $bid       = Branch::where('user_id', Auth::id())->first();
            $product_reqs = ProductRequest::where('branch_id', $bid->branch_id)
                                            ->join('products', 'product_requests.product_code', '=', 'products.product_code')
                                            ->orderByRaw("CASE status
                                                WHEN 'transferred' THEN 1
                                                WHEN 'accepted' THEN 2
                                                WHEN 'sent' THEN 3
                                                ELSE 4
                                                END")
                                            ->orderBy('order_date', 'desc')
                                            ->orderBy('product_code', 'asc')   
                                            ->paginate(9, ['products.name', 'product_requests.*']);
            return response()->json($product_reqs,200);
        }else {
            return response('Unauthorized', 401);
        }
    }

    public function store(Request $request)
    {
        if ($request->user()->cannot('create', ProductRequest::class)) {
            return response('Unauthorized', 401);
        }
        $validator = $this->validate($request, [
            'product_code'  => 'required',
        'warehouse_id'  => 'required',
            'amount'        => 'required|max:15',
            
        ]);

        $bid = Branch::where('user_id', Auth::Id())->first();
        $product_code = $request->input('product_code');
        $amount = $request->input('amount');
        $order_date = $request->input('order_date');
        if ($order_date == '') {
            $order_date = Carbon::today('Asia/Jakarta')->toDateString();
        }
        
        $product_req = ProductRequest::create([
            'request_id'    => Str::uuid()->toString(),
            'branch_id'     => $bid->branch_id,
            'product_code'  => $request->input('product_code'),
            'amount'        => $request->input('amount'),
            'warehouse_id'  => $request->input('warehouse_id'),
            'order_date'    => $order_date,
            
        ]);
        $uh = new UserHelper;
        if ($product_req) {
            Log::create([
                'user_id' => Auth::id(),
                'datetime' => Carbon::now('Asia/Jakarta'),
                'activity' => 'Product Request(s)',
                'detail' => 'Branch "'.$bid.'" Requested Product "'.$product_code.'" with amount "'.$amount
            ]);
            return response()->json(['message' => 'Data added successfully'], 201);
        }else {
            return response()->json("Failure");
        }
    }
    
    public function show(Request $request, $id)
    {
        if ($request->user()->cannot('viewAny', ProductRequest::class)) {
            return response('Unauthorized', 401);
        }
        $product_req = ProductRequest::find($id);
        return response()->json($product_req);
    }

    public function showStock(Request $request, $productCode, $stock)
    {
        if ($request->user()->cannot('viewStock', Warehouse::class)) {
            return response('Unauthorized', 401);
        }
        $warehouse = Warehouse::where('product_code', $productCode)
                              ->where('stock', '>=', $stock+10)
                              ->get(['warehouse_id', 'stock']);
        if (count($warehouse) < 1) {
            $warehouse = Warehouse::where('product_code', $productCode)
                              ->get('warehouse_id');
            return response()->json(['message' => 'Currently the stock in the warehouse is less than your request','data' => $warehouse]);
        }
        return response()->json($warehouse);
    }

    public function update(Request $request, $id)
    {
        if ($request->user()->cannot('update', ProductRequest::class)) {
            return response('Unauthorized', 401);
        }
        $validator = $this->validate($request, [
            'product_code'  => 'required',
            'amount'        => 'required',
            'warehouse_id'  => 'required',
        ]);
        $bid = Branch::where('user_id', Auth::Id())->first();
        $product_code = $request->input('product_code');
        $amount = $request->input('amount');

        $product_req = ProductRequest::where('request_id',$id)->update([
            'product_code'  => $request->input('product_code'),
            'amount'        => $request->input('amount'),
            'warehouse_id'  => $request->input('warehouse_id'),
        ]);
        $uh = new UserHelper;
        if ($product_req) {
            Log::create([
                'user_id' => Auth::id(),
                'datetime' => Carbon::now('Asia/Jakarta'),
                'activity' => 'Product Request(s)',
                'detail' => 'Branch "'.$bid.'" Requested Product "'.$product_code.'" with amount "'.$amount
            ]);
            return response()->json(['message' => 'Data updated successfully'], 201);
        }else {
            return response()->json("Failure");
        }
    }

    public function decline(Request $request)
    {
        if ($request->user()->cannot('checkRoleW', ProductRequest::class)) {
            return response('Unauthorized', 401);
        }
        $id = $request->input('request_id');
        $a = ProductRequest::where('request_id', $id)
                           ->update(['status' => 4]);
        return response()->json(['message' => 'Request Rejected']);
    }

    public function accept(Request $request)
    {
        if ($request->user()->cannot('checkRoleW', ProductRequest::class)) {
            return response('Unauthorized', 401);
        }
        $id = $request->input('request_id');
        $a = ProductRequest::where('request_id', $id)
                           ->update(['status' => 2]);
        return response()->json(['message' => 'Request Accepted']);
    }
    
    public function destroy(Request $request, $id)
    {
        if ($request->user()->cannot('delete', ProductRequest::class)) {
            return response('Unauthorized', 401);
        }
        $product_req = ProductRequest::destroy($id);

        if(!$product_req){
            return response()->json(['message' => 'Request Not Deleted']);
        }

        return response()->json(['message' => 'Deleted']);
    }
}
