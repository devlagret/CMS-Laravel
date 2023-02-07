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
use Illuminate\Support\Str;

class ProductRequestController extends Controller
{
    
    public function index(Request $request)
    {
        $uh = new UserHelper();
        if ($request->user()->cannot('viewAny', ProductRequest::class)) {
            return response('Unauthorized', 401);
        }
        $product_reqs = ProductRequest::simplePaginate(10);
        
        return response()->json($product_reqs);
    }

    
    public function store(Request $request)
    {
        if ($request->user()->cannot('create', ProductRequest::class)) {
            return response('Unauthorized', 401);
        }
        $validator = $this->validate($request, [
            'branch_id'     => 'required',
            'product_code'  => 'required',
            'amount'        => 'required|max:15',
            'order_date'    => 'required',
            'out_date'      => 'required',
            'status'        => 'required',
        ]);
        $branch_id = $request->input('branch_id');
        $product_code = $request->input('product_code');
        $amount = $request->input('amount');
        
        $product_req = ProductRequest::create([
            'request_id'    => Str::uuid()->toString(),
            'branch_id'     => $request->input('branch_id'),
            'product_code'  => $request->input('product_code'),
            'amount'        => $request->input('amount'),
            'order_date'    => $request->input('order_date'),
            'out_date'      => $request->input('out_date'),
            'status'        => $request->input('status'),
        ]);
        $uh = new UserHelper;
        if ($product_req) {
            Log::create([
                'user_id' => $uh->getUserData($request->header('token'))->user_id,
                'datetime' => Carbon::now('Asia/Jakarta'),
                'activity' => 'Product Request(s)',
                'detail' => 'Branch "'.$branch_id.'" Requested Product "'.$product_code.'" with amount "'.$amount
            ]);
            return response()->json(['message' => 'Data added successfully'], 201);
        }else {
            return response()->json("Failure");
        }

        //return response()->json($product_req);
    }

    
    public function show(Request $request, $id)
    {
        if ($request->user()->cannot('update', ProductRequest::class)) {
            return response('Unauthorized', 401);
        }
        if ($request->user()->cannot('view', ProductRequest::class)||$request->user()->cannot('viewAny', ProductRequest::class)) {
            return response('Unauthorized', 401);
        }
        $product_req = ProductRequest::find($id);
        return response()->json($product_req);
    }

    public function update(Request $request, $id)
    {
        $validator = $this->validate($request, [
            'branch_id'     => 'required',
            'product_code'  => 'required',
            'amount'        => 'required',
            'order_date'    => 'required',
            'out_date'      => 'required',
            'status'        => 'required',
        ]);
        $branch_id = $request->input('branch_id');
        $product_code = $request->input('product_code');
        $amount = $request->input('amount');

        $product_req = ProductRequest::where('request_id',$id)->update([
            'branch_id'     => $request->input('branch_id'),
            'product_code'  => $request->input('product_code'),
            'amount'        => $request->input('amount'),
            'order_date'    => $request->input('order_date'),
            'out_date'      => $request->input('out_date'),
            'status'        => $request->input('status'),
        ]);
        $uh = new UserHelper;
        if ($product_req) {
            Log::create([
                'user_id' => $uh->getUserData($request->header('token'))->user_id,
                'datetime' => Carbon::now('Asia/Jakarta'),
                'activity' => 'Product Request(s)',
                'detail' => 'Branch "'.$branch_id.'" Requested Product "'.$product_code.'" with amount "'.$amount
            ]);
            return response()->json(['message' => 'Data added successfully'], 201);
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
