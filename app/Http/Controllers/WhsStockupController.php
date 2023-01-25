<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\Tokens;
use App\Models\User;
use App\Models\whs_stockup;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WhsStockupController extends Controller
{
    public function index()
    {
        $stockups = whs_stockup::get();
  
        return response()->json($stockups);
    }

    public function store(Request $request)
    {
        $validator = $this->validate($request, [
            
            'supplier_id'    => 'required',
            'product_code'    => 'required',
            'purchase_date'    => 'required',
            'total_amont'    => 'required',
            'quantity'    => 'required',
        ]);
        
        $category_name = $request->input('supplier_id');
        $category_name = $request->input('product_code');
        $category_type = $request->input('purchase_date');
        $category_type = $request->input('total_amont');
        $category_type = $request->input('quantity');

        $category = whs_stockup::create([
        
            'supplier_id
            '    => $category_name,
            'product_code'    => $category_name,
            'purchase_date'    => $category_type,
            'total_amont'    => $category_type,
            'quantity'    => $category_type,
        ]);

        if ($category) {
            Logs::create([
                'uid'   => $uid->id,
                'datetime'  => Carbon::now('Asia/Jakarta'),
                'activity'  => 'Add Category(s)',
                'detail'    => 'Add Category with type "'.$category_type.'" named "'.$category_name
            ]);
            return response()->json(['message' => 'Data added successfully'], 201);
        }else {
            return response()->json("Failure");
        }
    }
}
