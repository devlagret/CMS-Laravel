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
        } while ($a > 0);
        
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
            return response()->json('Category Not Found', 404);
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
    public function trash(Request $request, $id = null)
    {
        if ($request->user()->cannot('viewAny', User::class)) {
            return response('Unauthorized', 401);
        }
        if ($id != null) {
            $trash = Category::onlyTrashed()->find($id);
            if (!$trash) {
                return response('Id Not Found', 404);
            }
            if ($trash->isEmpty()) {
                return response('No Category Trased', 404);
            }
            return response()->json($trash);
        }
        $trash = Category::onlyTrashed()->get();
        if ($trash->isEmpty()) {
            return response('No Category Trased', 404);
        }
        return response()->json($trash);
    }
    public function restore(Request $request)
    {
        if ($request->user()->cannot('viewAny', Category::class)) {
            return response('Unauthorized', 401);
        }
        $this->validate($request, ['category_id' => 'required|min:36']);
        $id = explode(",", str_replace(" ", "", $request['category_id']));
        $restore = Category::whereIn('category_id', $id)->restore();
        if (!$restore) {
            return response('Failure', 500);
        }
        return response('Restore Sucess');
    }
    public function restoreAll(Request $request)
    {
        if ($request->user()->cannot('viewAny', Category::class)) {
            return response('Unauthorized', 401);
        }
        $restore = Category::onlyTrashed()->restore();
        if (!$restore) {
            return response('Failure', 500);
        }
        return response('Restore Sucess');
    }
    public function delete(Request $request)
    {
        if ($request->user()->cannot('viewAny', Category::class)) {
            return response('Unauthorized', 401);
        }
        if ($request->isMethod('DELETE')) {
            $delete = Category::onlyTrashed()->forceDelete();
            if (!$delete) {
                return response('Failure', 500);
            }
            return response('Restore Sucess');
        }
        if ($request->isMethod('POST')) {
            $this->validate($request, ['category_id' => 'required|min:36']);
            $id = explode(",", str_replace(" ", "", $request['category_id']));
            $delete = Category::whereIn('category_id', $id)->forceDelete();
            if (!$delete) {
                return response('Failure', 500);
            }
            return response('Restore Sucess');
        }
        return response('Forbiden Method', 403);
    }
}
