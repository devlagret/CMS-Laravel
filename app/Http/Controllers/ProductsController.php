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
            'Product_Code'    => 'required',
            'Brand'    => 'required',
            'Name'    => 'required',
            'type'    => 'required',
            'category_id'    => 'required',
            'buy_price'    => 'required',
            'Price_Recomendation_from_Sup'    => 'required',
            'Price_Recomendation'    => 'required',
            'Profit_Margin'    => 'required',
            'Entry_Date'    => 'required',
            'Out_Date'    => 'required',
            'Expiration_Date'    => 'required',
            'Description'    => 'required',
            'Property'    => 'required',
            'supplier_id'    => 'required', 
        ]);
        $Product_Code = $request->input('Product_Code');
        $Brand = $request->input('Brand');
        $Name = $request->input('Name');
        $type = $request->input('type');
        $category_id = $request->input('category_id');
        $buy_price = $request->input('buy_price');
        $Price_Recomendation_from_Sup = $request->input('Price_Recomendation_from_Sup');
        $Price_Recomendation = $request->input('Price_Recomendation');
        $Profit_Margin = $request->input('Profit_Margin');
        $Entry_Date = $request->input('Entry_Date');
        $Out_Date = $request->input('Out_Date');
        $Expiration_Date = $request->input('Expiration_Date');
        $Description = $request->input('Description');
        $Property = $request->input('Property');
        $supplier_id = $request->input('supplier_id');

        $product = Product_Requests::create([
            'Product_Code'    => $Product_Code,
            'Brand'    => $Brand,
            'Name'    => $Name,
            'type'    => $type,
            'category_id'    => $category_id,
            'buy_price'    => $buy_price,
            'Price_Recomendation_from_Sup'    => $Price_Recomendation_from_Sup,
            'Price_Recomendation'    => $Price_Recomendation,
            'Profit_Margin'    => $Profit_Margin,
            'Entry_Date'    => $Entry_Date,
            'Out_Date'    => $Out_Date,
            'Expiration_Date'    => $Expiration_Date,
            'Description'    => $Description,
            'Property'    => $Property,
            'supplier_id'    => $supplier_id,
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
            'Product_Code'    => 'required',
            'Brand'    => 'required',
            'Name'    => 'required',
            'type'    => 'required',
            'category_id'    => 'required',
            'buy_price'    => 'required',
            'Price_Recomendation_from_Sup'    => 'required',
            'Price_Recomendation'    => 'required',
            'Profit_Margin'    => 'required',
            'Entry_Date'    => 'required',
            'Out_Date'    => 'required',
            'Expiration_Date'    => 'required',
            'Description'    => 'required',
            'Property'    => 'required',
            'supplier_id'    => 'required', 
        ]);
        $Product_Code = $request->input('Product_Code');

        $product = product::whereId($id)->update([
            'Product_Code'                 => $request->input('Product_Code'),
            'Brand'                        => $request->input('Brand'),
            'Name'                         => $request->input('Name'),
            'type'                         => $request->input('type'),
            'category_id'                  => $request->input('category_id'),
            'buy_price'                    => $request->input('buy_price'),
            'Price_Recomendation_from_Sup' => $request->input('Price_Recomendation_from_Sup'),
            'Price_Recomendation'          => $request->input('Price_Recomendation'),
            'Profit_Margin'                => $request->input('Profit_Margin'),
            'Entry_Date'                   => $request->input('Entry_Date'),
            'Out_Date'                     => $request->input('Out_Date'),
            'Expiration_Date'              => $request->input('Expiration_Date'),
            'Description'                  => $request->input('Description'),
            'Property'                     => $request->input('Property'),
            'supplier_id'                  => $request->input('supplier_id'),
            
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
}
