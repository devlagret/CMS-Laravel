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
use App\Models\Categories;
use App\Models\Suppliers;

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
            'Product_Code'        => 'required',
            'Brand'               => 'required',
            'Name'                => 'required',
            'category_id'         => 'required',
            'buy_price'           => 'required',
            'price_rec'           => 'required',
            'price_rec_from_sup'  => 'required',
            'Profit_Margin'       => 'required',
            // 'Entry_Date'          => 'required',
            // 'Out_Date'            => 'required',
            // 'Expiration_Date'     => 'required',
            'Description'         => 'required',
            'Property'            => 'required',
            'supplier_id'         => 'required', 
        ]);
        $Product_Code = $request->input('Product_Code');

        $product = product::create([
            'Product_Code'        => $Product_Code,
            'Brand'               => $request->input('Brand'),
            'Name'                => $request->input('Name'),
            'category_id'         => $request->input('category_id'),
            'buy_price'           => $request->input('buy_price'),
            'price_rec'           => $request->input('price_rec'),
            'price_rec_from_sup'  => $request->input('price_rec_from_sup'),
            'Profit_Margin'       => $request->input('Profit_Margin'),
            'Entry_Date'          => $request->input('Entry_Date'),
            'Out_Date'            => $request->input('Out_Date'),
            'Expiration_Date'     => $request->input('Expiration_Date'),
            'Description'         => $request->input('Description'),
            'Property'            => $request->input('Property'),
            'supplier_id'         => $request->input('supplier_id'),
        ]);
        $uh = new UserHelper;
        if ($product) {
            Logs::create([
                'user_id' => $uh->getUserData($request->header('token'))->uid,
                'datetime' => Carbon::now('Asia/Jakarta'),
                'activity' => 'Add Product(s)',
                'detail' => 'Add Product information with Code '.$Product_Code
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
            'Product_Code'        => 'required',
            'Brand'               => 'required',
            'Name'                => 'required',
            'category_id'         => 'required',
            'buy_price'           => 'required',
            'Price_Rec'           => 'required',
            'Price_Rec_from_Sup'  => 'required',
            'Profit_Margin'       => 'required',
            'Entry_Date'          => 'required',
            'Out_Date'            => 'required',
            'Expiration_Date'     => 'required',
            'Description'         => 'required',
            'Property'            => 'required',
            'supplier_id'         => 'required',
        ]);
        $Product_Code = $request->input('Product_Code');

        $product = product::whereId($id)->update([
            'Product_Code'       => $request->input('Product_Code'),
            'Brand'              => $request->input('Brand'),
            'Name'               => $request->input('Name'),
            'type'               => $request->input('type'),
            'category_id'        => $request->input('category_id'),
            'buy_price'          => $request->input('buy_price'),
            'Price_Rec'          => $request->input('Price_Recomendation'),
            'Price_Rec_from_Sup' => $request->input('Price_Recomendation_from_Sup'),
            'Profit_Margin'      => $request->input('Profit_Margin'),
            'Entry_Date'         => $request->input('Entry_Date'),
            'Out_Date'           => $request->input('Out_Date'),
            'Expiration_Date'    => $request->input('Expiration_Date'),
            'Description'        => $request->input('Description'),
            'Property'           => $request->input('Property'),
            'supplier_id'        => $request->input('supplier_id'),
            
        ]);
        $uh = new UserHelper;
        if ($product) {
            Logs::create([
                'user_id' => $uh->getUserData($request->header('token'))->uid,
                'datetime' => Carbon::now('Asia/Jakarta'),
                'activity' => 'Update Product(s)',
                'detail' => 'Update Product information with Code '.$Product_Code
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

    public function category($id){

    }
    public function supplier($id){
        
    }
}
