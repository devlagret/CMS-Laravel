<?php

namespace App\Http\Controllers;

use App\Models\Products as product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $products = Product::get();
  
        return response()->json($products);
    }

    public function store(Request $request)
    {
        
        $product = new Product();
        $product->Product_Code = $request->Product_Code;
        $product->Brand = $request->Brand;
        $product->Name = $request->Name;
        $product->type = $request->type;
        $product->category_id = $request->category_id;
        $product->buy_price = $request->buy_price;
        $product->Price_Recomendation_from_Sup = $request->Price_Recomendation_from_Sup;
        $product->Price_Recomendation = $request->Price_Recomendation;
        $product->Profit_Margin = $request->Profit_Margin;
        $product->Entry_Date = $request->Entry_Date;
        $product->Out_Date = $request->Out_Date;
        $product->Expiration_Date = $request->Expiration_Date;
        $product->Description = $request->Description;
        $product->Property = $request->Property;
        $product->supplier_id = $request->supplier_id;
        $project->save();

        return response()->json($product);
    }

    public function show($id)
    {
        $product = Product::find($id);

        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        // $product = Product::find($id);
        // $product->Product_Code = $request->Product_Code;
        // $product->Brand = $request->Brand;
        // $product->Name = $request->Name;
        // $product->type = $request->type;
        // $product->category_id = $request->category_id;
        // $product->buy_price = $request->buy_price;
        // $product->Price_Recomendation_from_Sup = $request->Price_Recomendation_from_Sup;
        // $product->Price_Recomendation = $request->Price_Recomendation;
        // $product->Profit_Margin = $request->Profit_Margin;
        // $product->Entry_Date = $request->Entry_Date;
        // $product->Out_Date = $request->Out_Date;
        // $product->Expiration_Date = $request->Expiration_Date;
        // $product->Description = $request->Description;
        // $product->Property = $request->Property;
        // $product->supplier_id = $request->supplier_id;
        // $project->save();
        $product_req = product_request::whereId($id)->update([
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

        return response()->json($product);
    }

    public function destroy($id)
    {
        Product::destroy($id);

        return response()->json(['message' => 'Deleted']);
    }
}
