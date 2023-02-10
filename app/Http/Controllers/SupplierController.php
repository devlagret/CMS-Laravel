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
        $suppliers = Supplier::paginate(9);
  
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

    public function showByName(Request $request)
    {
        if ($request->user()->cannot('viewAny', Supplier::class)&&$request->user()->cannot('viewAny', Supplier::class)) {
            return response('Unauthorized', 401);
        }
        $validator = $this->validate($request, [
            'supplier_name' => 'required',
        ]);

        $name = $request->input('supplier_name');
        $supplier = Supplier::where('supplier_name', 'LIKE', '%'.$name.'%')->paginate(9);

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
            'address'        => 'required',
        ]);
        $supplier_name = $request->input('supplier_name');
        
        $supplier = Supplier::where('supplier_id', $id)->update([
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
    public function trash(Request $request, $id = null)
    {
        if ($request->user()->cannot('viewAny', User::class)) {
            return response('Unauthorized', 401);
        }
        if ($id != null) {
            $trash = Supplier::onlyTrashed()->find($id);
            if (!$trash) {
                return response('Id Not Found', 404);
            }
            if ($trash->isEmpty()) {
                return response('No Supplier Trased', 404);
            }
            return response()->json($trash);
        }
        $trash = Supplier::onlyTrashed()->get();
        if ($trash->isEmpty()) {
            return response('No Supplier Trased', 404);
        }
        return response()->json($trash);
    }
    public function restore(Request $request)
    {
        if ($request->user()->cannot('viewAny', Supplier::class)) {
            return response('Unauthorized', 401);
        }
        $this->validate($request, ['supplier_id' => 'required|min:36']);
        $id = explode(",", str_replace(" ", "", $request['supplier_id']));
        $restore = Supplier::whereIn('supplier_id', $id)->restore();
        if (!$restore) {
            return response('Failure', 500);
        }
        return response('Restore Sucess');
    }
    public function restoreAll(Request $request)
    {
        if ($request->user()->cannot('viewAny', Supplier::class)) {
            return response('Unauthorized', 401);
        }
        $restore = Supplier::onlyTrashed()->restore();
        if (!$restore) {
            return response('Failure', 500);
        }
        return response('Restore Sucess');
    }
    public function delete(Request $request)
    {
        if ($request->user()->cannot('viewAny', Supplier::class)) {
            return response('Unauthorized', 401);
        }
        if ($request->isMethod('DELETE')) {
            $delete = Supplier::onlyTrashed()->forceDelete();
            if (!$delete) {
                return response('Failure', 500);
            }
            return response('Restore Sucess');
        }
        if ($request->isMethod('POST')) {
            $this->validate($request, ['supplier_id' => 'required|min:36']);
            $id = explode(",", str_replace(" ", "", $request['supplier_id']));
            $delete = Supplier::whereIn('supplier_id', $id)->forceDelete();
            if (!$delete) {
                return response('Failure', 500);
            }
            return response('Restore Sucess');
        }
        return response('Forbiden Method', 403);
    }
}
