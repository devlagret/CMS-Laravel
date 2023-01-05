<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SuppliersController extends Controller
{
    public function index()
    {
        $suppliers = Suppliers::get();
  
        return response()->json($suppliers);
    }

    public function store(Request $request)
    {
        $supplier = new Suppliers;
        $supplier->supplier_name = $request->supplier_name;
        $supplier->contact = $request->contact;
        $supplier->address = $request->address;
        $supplier->save;

        return response()->json($supplier);
    }

    public function show($id)
    {
        $supplier = Suppliers::find($id);

        return response()->json($supplier);
    }

    public function update(Request $request, $id)
    {
        // $supplier = Suppliers::find($id);
        // $supplier->category_name = $request->category_name;
        // $supplier->category_type = $request->category_type;
        // $supplier->save;
        $branch = Branches::whereId($id)->update([
            'supplier_name' => $request->input('supplier_name'),
            'contact'       => $request->input('contact'),
            'address'       => $request->input('address'),
        ]);

        return response()->json($supplier);
    }

    public function destroy($id)
    {
        Suppliers::destroy($id);

        return response()->json(['message' => 'Deleted']);
    }
}
