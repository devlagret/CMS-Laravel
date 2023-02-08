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
        // $id = substr($category_type, 0, 1).'-'.substr($category_name, 0, 2);
        $id = preg_replace('/([a-z])/', '', $t).'-'.preg_replace('/([a-z])/', '', $n);
        $nums = 0;
        $num = Category::where('category_id', 'like', $id . '%')->orderBy('category_id', 'desc')->first('category_id');
        if ($num) {
            $num = json_encode(array($num), JSON_NUMERIC_CHECK);
            $num = intval(preg_replace('/[^0-9]/', '', $num)); 
            $num = $nums+1;
            $id = preg_replace('/([a-z])/', '', $t).'-'.preg_replace('/([a-z])/', '', $n).'-'.$num;
        }else {
            $id = preg_replace('/([a-z])/', '', $t).'-'.preg_replace('/([a-z])/', '', $n).'-'.$nums;
        }
        
        $category = Category::create([
            'category_id'      => $id,
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
        if ($request->user()->cannot('view', Category::class)||$request->user()->cannot('viewAny', Category::class)) {
            return response('Unauthorized', 401);
        }
        $category = Category::find($id);

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
        // $id = substr($category_type, 0, 1).'-'.substr($category_name, 0, 2);
        $num = 2;
        $cid = preg_replace('/([a-z])/', '', $t).'-'.strtoupper(substr($category_name, 0, $num));
        $count = Category::where('category_id', 'like', $cid . '%')->get('category_id');
        while ($count && count($count) != 1 ) {
            $num++;
        }

        Category::destroy($id);
        $category = Category::create([
            'category_id' => $cid,
            'category_name' => $category_name,
            'category_type' => $category_type,
        ]);
        
        // $uh = new UserHelper;
        // if ($category) {
        //     Log::create([
        //         'user_id' => $uh->getUserData($request->header('token'))->user_id,
        //         'datetime' => Carbon::now('Asia/Jakarta'),
        //         'activity' => 'Update Category(s)',
        //         'detail' => 'Update Category with type "'.$category_type.'" named "'.$category_name
        //     ]);
        //     return response()->json(['message' => 'Data updated successfully'], 200);
        // }else {
        //     return response()->json("Failure");
        // }
        return response()->json(count($count));
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
