<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suppliers;
use App\Models\Users;
use App\Models\Tokens;
use App\Models\Logs;
use Carbon\Carbon;
use App\Helpers\UserHelper;

class SuppliersController extends Controller
{
    
    public function index()
    {
        $suppliers = Suppliers::get();
  
        return response()->json($suppliers);
    }

    public function store(Request $request)
    {
        $validator = $this->validate($request, [
            'supplier_name'  => 'required',
            'contact'        => 'required',
            'address'        => 'required|max:15',
        ]);
        $supplier_name = $request->input('supplier_name');

        $supplier = Suppliers::create([
            'supplier_name'  => $request->input('supplier_name'),
            'contact'        => $request->input('contact'),
            'address'        => $request->input('address'),
        ]);
        $uh = new UserHelper;
        if ($supplier) {
            Logs::create([
                'uid' => $uh->getUserData($request->header('token'))->uid,
                'datetime' => Carbon::now('Asia/Jakarta'),
                'activity' => 'Add Supplier(s)',
                'detail' => 'Add Supplier information with name '.$supplier_name
            ]); 
            return response()->json(['message' => 'Data added successfully'], 201);
        }else {
            return response()->json("Failure");
        }
    }

    public function show($id)
    {
        $supplier = Suppliers::find($id);

        return response()->json($supplier);
    }

    public function update(Request $request, $id)
    {
            $validator = $this->validate($request, [
            'supplier_name'  => 'required',
            'contact'        => 'required',
            'address'        => 'required|max:15',
        ]);
        $supplier_name = $request->input('supplier_name');
        
        $supplier = Suppliers::whereId($id)->update([
            'supplier_name' => $request->input('supplier_name'),
            'contact'       => $request->input('contact'),
            'address'       => $request->input('address'),
        ]);
        $uh = new UserHelper;
        if ($supplier) {
            Logs::create([
                'uid'   => $uh->getUserData($request->header('token'))->uid,
                'datetime'  => Carbon::now('Asia/Jakarta'),
                'activity'  => 'Update Supplier(s)',
                'detail'    => 'Update Supplier information with name '.$supplier_name
            ]); 
            return response()->json(['message' => 'Data added successfully'], 201);
        } else {
            return response()->json("Failure");
        }
    }

    public function destroy($id)
    {
        Suppliers::destroy($id);

        return response()->json(['message' => 'Deleted']);
    }
}
