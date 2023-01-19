<?php

namespace App\Http\Controllers;

use App\Models\Products as product;
use App\Models\Product_Requests;
use App\Models\Tokens;
use App\Models\Users;
use App\Models\Logs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;

class ProductsController extends Controller
{
    
    public function index()
    {
        $products = Product::get();
  
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $validator = $this->validate($request, [
            'product_code'        => 'required',
            'brand'               => 'required',
            'name'                => 'required',
            'category_id'         => 'required',
            'buy_price'           => 'required',
            'price_rec'           => 'required',
            'price_rec_from_sup'  => 'required',
            'profit_margin'       => 'required',
            'description'         => 'required',
            'property'            => 'required',
            'supplier_id'         => 'required',
        ]);
        $product_code = $request->input('product_code');

        $product = product::create([
            'product_code'        => $product_code,
            'brand'               => $request->input('brand'),
            'name'                => $request->input('name'),
            'category_id'         => $request->input('category_id'),
            'buy_price'           => $request->input('buy_price'),
            'price_rec'           => $request->input('price_rec'),
            'price_rec_from_sup'  => $request->input('price_rec_from_sup'),
            'profit_margin'       => $request->input('profit_margin'),
            'description'         => $request->input('description'),
            'property'            => $request->input('property'),
            'supplier_id'         => $request->input('supplier_id'),
        ]);
        $uh = new UserHelper;
        if ($product) {
            Logs::create([
                'uid' => $uh->getUserData($request->header('token'))->uid,
                'datetime' => Carbon::now('Asia/Jakarta'),
                'activity' => 'Add Product(s)',
                'detail' => 'Add Product information with Code '.$product_code
            ]);
            return response()->json(['message' => 'Data added successfully'], 201);
        }else {
            return response()->json("Failure");
        }
    }

    public function show($id)
    {
        $product = Product::find($id);

        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $validator = $this->validate($request, [
            'product_code'        => 'required',
            'brand'               => 'required',
            'name'                => 'required',
            'category_id'         => 'required',
            'buy_price'           => 'required',
            'price_rec'           => 'required',
            'price_rec_from_sup'  => 'required',
            'profit_margin'       => 'required',
            'description'         => 'required',
            'property'            => 'required',
            'supplier_id'         => 'required',
        ]);
        $product_code = $request->input('product_code');

        $product = product::whereId($id)->update([
            'product_code'       => $request->input('product_code'),
            'brand'              => $request->input('brand'),
            'name'               => $request->input('name'),
            'category_id'        => $request->input('category_id'),
            'buy_price'          => $request->input('buy_price'),
            'price_rec'          => $request->input('price_rec'),
            'price_rec_from_sup' => $request->input('price_rec_from_sup'),
            'profit_margin'      => $request->input('profit_margin'),
            'description'        => $request->input('description'),
            'property'           => $request->input('property'),
            'supplier_id'        => $request->input('supplier_id'),
            
        ]);
        $uh = new UserHelper;
        if ($product) {
            Logs::create([
                'uid' => $uh->getUserData($request->header('token'))->uid,
                'datetime' => Carbon::now('Asia/Jakarta'),
                'activity' => 'Update Product(s)',
                'detail' => 'Update Product information with Code '.$product_code
            ]);
            return response()->json(['message' => 'Data added successfully'], 201);
        }else {
            return response()->json("Failure");
        }
    }

    public function destroy($id)
    {
        Product::destroy($id);

        return response()->json(['message' => 'Deleted']);
    }

    public function search(Request $request)
    {
        if ($request->id) {
            $product = Product::find($request->id);
        } elseif ($request->name) {
            $product = Product::find($request->name);
        } elseif ($request->code) {
            $product = Product::find($request->code);
        }
    }
}
