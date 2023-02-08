<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Log;
use App\Models\Token;
use App\Models\User;
use Carbon\Carbon;
use App\Helpers\UserHelper;

class CategoryController extends Controller
{
    
    public function index(Request $request, $id=null)
    {
        if ($request->user()->cannot('viewAny', Category::class)) {
            return response('Unauthorized', 401);
        }
        $categories = Category::get();
  
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        if ($request->user()->cannot('create', Category::class)) {
            return response('Unauthorized', 401);
        }
        $validator = $this->validate($request, [
            'category_name'    => 'required',
            'category_type'    => 'required',
        ]);
        $category_name = $request->input('category_name');
        $category_type = $request->input('category_type');
        $t = str_replace(['-', ' '], '', $category_type);
        $n = str_replace(' ', '', $category_name);
        
        $num = 1;
        do {
            $cid = preg_replace('/([a-z])/', '', $t).'-'.strtoupper(substr($category_name, 0, $num));
            $a = Category::where('category_id', 'like', $cid . '%')->count();
            $num++;
        } while ($a > 1);
        
        $category = Category::create([
            'category_id'      => $cid,
            'category_name'    => $category_name,
            'category_type'    => $category_type,
        ]);
        $uh = new UserHelper;
        if ($category) {
            Log::create([
                'user_id' => $uh->getUserData($request->header('token'))->user_id,
                'datetime' => Carbon::now('Asia/Jakarta'),
                'activity' => 'Add Category(s)',
                'detail' => 'Add Category with type "'.$category_type.'" named "'.$category_name
            ]);
            return response()->json(['message' => 'Data added successfully'], 201);
        }else {
            return response()->json("Failure");
        }
    }

    public function show(Request $request,$id)
    {
        // if ($request->user()->cannot('view', Category::class)||$request->user()->cannot('viewAny', Category::class)) {
        //     return response('Unauthorized', 401);
        // }
        $category = Category::find($id);
        if (!$category) {
            return response()->json('Supplier Not Found', 404);
        }

        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        if ($request->user()->cannot('update', Category::class)) {
            return response('Unauthorized', 401);
        }
        $validator = $this->validate($request, [
            'category_name'    => 'required',
            'category_type'    => 'required',
        ]);
        $category_name = $request->input('category_name');
        $category_type = $request->input('category_type');
        $t = str_replace(['-', ' '], '', $category_type);
        $n = str_replace(' ', '', $category_name);
        $num = 1;
        do {
            $cid = preg_replace('/([a-z])/', '', $t).'-'.strtoupper(substr($category_name, 0, $num));
            $a = Category::where('category_id', 'like', $cid . '%')->count();
            $num++;
        } while ($a > 1);

        $category = Category::find($id);
        if (!$category) {
            return response()->json('Supplier Not Found', 404);
        }else {
            Category::destroy($id);
            Category::create([
                'category_id' => $cid,
                'category_name' => $category_name,
                'category_type' => $category_type,
            ]);
        }
        
        $uh = new UserHelper;
        if ($category) {
            Log::create([
                'user_id' => $uh->getUserData($request->header('token'))->user_id,
                'datetime' => Carbon::now('Asia/Jakarta'),
                'activity' => 'Update Category(s)',
                'detail' => 'Update Category with type "'.$category_type.'" named "'.$category_name
            ]);
            return response()->json(['message' => 'Data updated successfully'], 200);
        }else {
            return response()->json("Failure");
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($request->user()->cannot('delete', Category::class)) {
            return response('Unauthorized', 401);
        }
        Category::destroy($id);

        return response()->json(['message' => 'Deleted']);
    }
}
