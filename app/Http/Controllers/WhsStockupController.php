<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\Tokens;
use App\Models\Users;
use App\Models\whs_stockup;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WhsStockupController extends Controller
{
    public function index()
    {
        $categories = whs_stockup::get();
  
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $token = $request->header('token');
        $uid = Tokens::where('token', '=', $token)->first();
        $usr = Users::where('id', $uid->id)->first();

        $validator = $this->validate($request, [
            'category_name'    => 'required',
            'category_type'    => 'required',
        ]);
        $category_name = $request->input('category_name');
        $category_type = $request->input('category_type');

        $category = whs_stockup::create([
            'category_name'    => $category_name,
            'category_type'    => $category_type,
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

    public function show($id)
    {
        $category = whs_stockup::find($id);

        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $token = $request->header('token');
        $uid = Tokens::where('token', '=', $token)->first();
        $usr = Users::where('id', $uid->id)->first();

        $validator = $this->validate($request, [
            'category_name'    => 'required',
            'category_type'    => 'required',
        ]);
        $category_name = $request->input('category_name');
        $category_type = $request->input('category_type');

        $category = whs_stockup::whereId($id)->update([
            'category_name'   => $request->input('category_name'),
            'category_type'   => $request->input('category_type'),
        ]);

        if ($category) {
            Logs::create([
                'uid'   => $uid->id,
                'datetime'  => Carbon::now('Asia/Jakarta'),
                'activity'  => 'Update Category(s)',
                'detail'    => 'Update Category with type "'.$category_type.'" named "'.$category_name
            ]);
            return response()->json(['message' => 'Data added successfully'], 201);
        }else {
            return response()->json("Failure");
        }
    }

    public function destroy($id)
    {
        whs_stockup::destroy($id);

        return response()->json(['message' => 'Deleted']);
    }
}
