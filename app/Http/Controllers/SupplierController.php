<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Token;
use App\Models\Log;
use Carbon\Carbon;
use App\Helpers\UserHelper;
use Illuminate\Support\Str;

class SupplierController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->user()->cannot('viewAny', Supplier::class)) {
            return response('Unauthorized', 401);
        }
        $suppliers = Supplier::get();
  
        return response()->json($suppliers);
    }

    public function store(Request $request)
    {
        if ($request->user()->cannot('create', Supplier::class)) {
            return response('Unauthorized', 401);
        }
        $validator = $this->validate($request, [
            'supplier_name'  => 'required',
            'contact'        => 'required',
            'address'        => 'required',
        ]);
        $supplier_name = $request->input('supplier_name');

        $supplier = Supplier::create([
            'supplier_id'    => Str::uuid()->toString(),
            'supplier_name'  => $request->input('supplier_name'),
            'contact'        => $request->input('contact'),
            'address'        => $request->input('address'),
        ]);
        $uh = new UserHelper;
        if ($supplier) {
            Log::create([
                'user_id' => $uh->getUserData($request->header('token'))->user_id,
                'datetime' => Carbon::now('Asia/Jakarta'),
                'activity' => 'Add Supplier(s)',
                'detail' => 'Add Supplier information with name '.$supplier_name
            ]); 
            return response()->json(['message' => 'Data added successfully'], 201);
        }else {
            return response()->json("Failure");
        }
    }

    public function show(Request $request, $id)
    {
        if ($request->user()->cannot('viewAny', Supplier::class)&&$request->user()->cannot('viewAny', Supplier::class)) {
            return response('Unauthorized', 401);
        }
        $supplier = Supplier::find($id);

        return response()->json($supplier);
    }

    public function update(Request $request, $id)
    {
        if ($request->user()->cannot('update', Supplier::class)) {
            return response('Unauthorized', 401);
        }
            $validator = $this->validate($request, [
            'supplier_name'  => 'required',
            'contact'        => 'required',
            'address'        => 'required|max:15',
        ]);
        $supplier_name = $request->input('supplier_name');
        
        $supplier = Supplier::whereId($id)->update([
            'supplier_name' => $request->input('supplier_name'),
            'contact'       => $request->input('contact'),
            'address'       => $request->input('address'),
        ]);
        $uh = new UserHelper;
        if ($supplier) {
            Log::create([
                'user_id'   => $uh->getUserData($request->header('token'))->user_id,
                'datetime'  => Carbon::now('Asia/Jakarta'),
                'activity'  => 'Update Supplier(s)',
                'detail'    => 'Update Supplier information with name '.$supplier_name
            ]); 
            return response()->json(['message' => 'Data added successfully'], 201);
        } else {
            return response()->json("Failure");
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($request->user()->cannot('delete', Supplier::class)) {
            return response('Unauthorized', 401);
        }
        Supplier::destroy($id);

        return response()->json(['message' => 'Deleted']);
    }
}
