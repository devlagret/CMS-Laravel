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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isEmpty;

class ProductRequestController extends Controller
{
    
    public function index(Request $request)
    {
        $uh = new UserHelper();
        if ($request->user()->cannot('viewAny', ProductRequest::class)) {
            return response('Unauthorized', 401);
        }
        $product_reqs = ProductRequest::paginate(10);
        
        return response()->json($product_reqs);
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
            'order_date'    => 'required',
        ]);

        $bid = Branch::where('user_id', Auth::Id())->first();
        $product_code = $request->input('product_code');
        $amount = $request->input('amount');
        $order_date = $request->input('order_date');
        
        $product_req = ProductRequest::create([
            'request_id'    => Str::uuid()->toString(),
            'branch_id'     => $bid->branch_id,
            'product_code'  => $request->input('product_code'),
            'amount'        => $request->input('amount'),
            'warehouse_id'  => $request->input('warehouse_id'),
            'order_date'    => isEmpty($order_date) ? Carbon::today('Asia/Jakarta')->toDateString() : $order_date,
            'out_date'      => $request->input('out_date'),
        ]);
        $uh = new UserHelper;
        if ($product_req) {
            Log::create([
                'user_id' => $uh->getUserData($request->header('token'))->user_id,
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
        if ($request->user()->cannot('view', ProductRequest::class)||$request->user()->cannot('viewAny', ProductRequest::class)) {
            return response('Unauthorized', 401);
        }
        $product_req = ProductRequest::find($id);
        return response()->json($product_req);
    }

    public function update(Request $request, $id)
    {
        if ($request->user()->cannot('update', ProductRequest::class)) {
            return response('Unauthorized', 401);
        }
        $validator = $this->validate($request, [
            'branch_id'     => 'required',
            'product_code'  => 'required',
            'amount'        => 'required',
            'order_date'    => 'required',
            'out_date'      => 'required',
            'status'        => 'required',
        ]);
        $bid = Branch::where('user_id', Auth::Id())->first();
        $product_code = $request->input('product_code');
        $amount = $request->input('amount');

        $product_req = ProductRequest::where('request_id',$id)->update([
            'branch_id'     => $bid->branch_id,
            'product_code'  => $request->input('product_code'),
            'amount'        => $request->input('amount'),
            'out_date'      => $request->input('out_date'),
        ]);
        $uh = new UserHelper;
        if ($product_req) {
            Log::create([
                'user_id' => $uh->getUserData($request->header('token'))->user_id,
                'datetime' => Carbon::now('Asia/Jakarta'),
                'activity' => 'Product Request(s)',
                'detail' => 'Branch "'.$bid.'" Requested Product "'.$product_code.'" with amount "'.$amount
            ]);
            return response()->json(['message' => 'Data updated successfully'], 201);
        }else {
            return response()->json("Failure");
        }
    }

    
    public function destroy(Request $request, $id)
    {
        if ($request->user()->cannot('delete', ProductRequest::class)) {
            return response('Unauthorized', 401);
        }
        ProductRequest::destroy($id);

        return response()->json(['message' => 'Deleted']);
    }
}
