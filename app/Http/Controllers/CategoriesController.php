<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Categories;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Categories::get();
  
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $category = new Categories;
        $category->category_name = $request->category_name;
        $category->category_type = $request->category_type;
        $category->save();

        return response()->json($category);
    }

    public function show($id)
    {
        $category = Categories::find($id);

        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        // $category = Categories::find($id);
        // $category->category_name = $request->category_name;
        // $category->category_type = $request->category_type;
        // $category->save;
        $category = categories::whereId($id)->update([
            'category_name'     => $request->input('category_name'),
            'category_type'   => $request->input('category_type'),
        ]);

        return response()->json($category);
    }

    public function destroy($id)
    {
        Categories::destroy($id);

        return response()->json(['message' => 'Deleted']);
    }
}
