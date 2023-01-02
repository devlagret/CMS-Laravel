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
        $uri = product::get();
        return response()->json($uri);
        // return product::
    }

    public function store(Request $request)
    {
        $uri = new product();
        $uri->name = $request->name;
        $uri->description = $request->description;
        $uri->save();
  
        return response()->json($uri);
    }

    public function show($id)
    {
        $uri = product::find($id);
        return response()->json($uri);
    }

    public function update(Request $request, $id)
    {
        $uri = product::find($id);
        $uri->name = $request->name;
        $uri->description = $request->description;
        $uri->save();
  
        return response()->json($uri);
    }

    public function destroy($id)
    {
        product::destroy($id);
  
        return response()->json(['message' => 'Deleted']);
    }
}
