<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelper;
use App\Models\Categories;
use App\Models\Logs;
use App\Models\Products;
use App\Models\Tokens;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Warehouses;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use stdClass;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Categories::get();
        
        return response()->json($warehouses);
    }

    
    public function store(Request $request)
    {
        $token = $request->header('token');
        $user_id = Tokens::where('token', '=', $token)->first();
        $usr = User::where('id', $user_id->id)->first();
        
        $validator = $this->validate($request, [
            'warehouse_id'  => 'required',
            'product_code'  => 'required',
            'stock'         => 'required|max:15',
            'entry_date'    => 'required',
            'location'      => 'required',
        ]);
        $branch_id = $request->input('warehouse_id');
        $product_code = $request->input('product_code');
        $amount = $request->input('stock');
        
        $warehouse = Warehouses::create([
            'warehouse_id'  => $request->input('warehouse_id'),
            'product_code'  => $request->input('product_code'),
            'stock'        => $request->input('stock'),
            'entry_date'    => $request->input('entry_date'),
            'location'      => $request->input('location'),
        ]);

        if ($warehouse) {
            Logs::create([
                'user_id'   => $user_id->id,
                'datetime'  => Carbon::now('Asia/Jakarta'),
                'activity'  => 'Product Request(s)',
                'detail'    => 'Branch "'.$branch_id.'" Requested Product "'.$product_code.'" with amount "'.$amount
            ]);
            return response()->json(['message' => 'Data added successfully'], 201);
        }else {
            return response()->json("Failure");
        }

        return response()->json($warehouse);
    }

    
    public function show($id)
    {
        $warehouse = Warehouses::find($id);
        return response()->json($warehouse);
    }

    public function update(Request $request, $id)
    {
        $token = $request->header('token');
        $user_id = Tokens::where('token', '=', $token)->first();
        $usr = User::where('id', $user_id->id)->first();

        $validator = $this->validate($request, [
            'branch_id'     => 'required',
            'product_code'  => 'required',
            'amount'        => 'required',
            'order_date'    => 'required',
            'out_date'      => 'required',
            'status'        => 'required',
        ]);
        $branch_id = $request->input('branch_id');
        $product_code = $request->input('product_code');
        $amount = $request->input('amount');

        $warehouse = Warehouses::whereId($id)->update([
            'branch_id'     => $request->input('branch_id'),
            'product_code'  => $request->input('product_code'),
            'amount'        => $request->input('amount'),
            'order_date'    => $request->input('order_date'),
            'out_date'      => $request->input('out_date'),
            'status'        => $request->input('status'),
        ]);

        if ($warehouse) {
            Logs::create([
                'user_id'   => $user_id->id,
                'datetime'  => Carbon::now('Asia/Jakarta'),
                'activity'  => 'Product Request(s)',
                'detail'    => 'Branch "'.$branch_id.'" Requested Product "'.$product_code.'" with amount "'.$amount
            ]);
            return response()->json(['message' => 'Data added successfully'], 201);
        }else {
            return response()->json("Failure");
        }
    }

    public function destroy($id)
    {
        Warehouses::destroy($id);

        return response()->json(['message' => 'Deleted']);
    }

    public function stockup(Request $request)
    {
        $warehouse = Warehouses::where('product_code',$request->product_code)->first();
        $warehouse->stock += $request->stock;
        $warehouse->save();
        
        return response()->json($warehouse);
    }
}

// $rules = [
//     'Supplier_id'=>'required',
//     'update_price'=>'required',
//     'items.*.id'=>'required',
//     'items.*.product_code'=>'required',
//     'items.*.buy_price'=>'required',
//     'items.*.stock'=>'required',
//     'items.*.price_rec'=>'required',
// ];
// $this->validate($request, $rules);

// $result = [];
// $items = $request;
// $data = count($items->items);
// for ($i=0; $i < count($items->items); $i++) { 
//     $result[$i] = [
//         'id'  => $items->items[$i]['id'],
//         'product_code' => $items->items[$i]['product_code'],
        // 'stock' => $items->items[$i]['stock'],
//         'brand' => $items->items[$i]['brand'],
//         'name' => $items->items[$i]['name'],
//         'category_id' => $items->items[$i]['category_id'],
//         'buy_price' => $items->items[$i]['buy_price'],
//         'price_rec' => $items->items[$i]['price_rec'],
//         'price_rec_from_sup' => $items->items[$i]['price_rec_from_sup'],
//         'profit_margin' => $items->items[$i]['profit_margin'],
//         'description' => $items->items[$i]['description'],
//         'property' => $items->items[$i]['property'],
//         'supplier_id' => $items->items[$i]['supplier_id']
//     ];
// }

// $ar =(object) $result;
// foreach($result as $k){
//             }
// $product = Products::firstOrCreate($result);
// return response()->json($ar->id);
// if ($product->wasRecentlyCreated) {
//     return response()->json('$product'); 
// }else {
//     return response()->json('$Product');
// }

// ====== Error on If always return true when create but when duplicate return error
// $product = Products::firstOrCreate($result[0]);
// if ($product->wasRecentlyCreated) {
//     return response()->json('$product'); 
// }else {
//     return response()->json('$Product');
// }

// $df = dd($request->json()->all());
// $input = $request;
// $con = $input['items']['skills'];
// $data = json_decode($request);
// $json = json_decode($request);
// $validator = Validator::make(
//     $con, [
//         'id' => 'digits:8',
//         'custom' => 'digits:8',
//     ]
// );
// if ($validator->passes()) {
//     if (Arr::has($input, 'id' )) {
//         return response()->json($con, 200);
        
// } else {
//     return response()->json('error bang', 404);
// }
// $validation = Validator::make(
//     $request->all(),
//     [
//         'name' => 'required|'
//     ]
// );

// if ($validation->fails()) {
//     dd($validation->getMessageBag()->all());
// } else {
    
// }

// return response()->json($json);

// ForEach Method
// foreach ($items->items as $item) {
//     $result[] =[
//         'product_id'  => $item['product_id'],
//         'product_code' => $item['product_code'],
//         'stock' => $item['stock'],
//         'brand' => $item['brand'],
//         'name' => $item['name'],
//         'category_id' => $item['category_id'],
//         'buy_price' => $item['buy_price'],
//         'price_rec' => $item['price_rec'],
//         'price_rec_from_sup' => $item['price_rec_from_sup'],
//         'Profit_Margin' => $item['Profit_Margin'],
//         'Description' => $item['Description'],
//         'Property' => $item['Property'],
//         'supplier_id' => $item['supplier_id']
//     ];

// $product = Products::firstOrCreate([
//     'product_id'  => $result['product_id'],
//     'Product_Code' => $result['product_code'],
//     'Brand' => $result['brand'],
//     'Name' => $result['name'],
//     'category_id' => $result['category_id'],
//     'buy_price' => $result['buy_price'],
//     'price_rec' => $result['price_rec'],
//     'price_rec_from_sup' => $result['price_rec_from_sup'],
//     'Profit_Margin' => $result['Profit_Margin'],
//     'Description' => $result['Description'],
//     'Property' => $result['Property'],
//     'Supplier_id' => $result['supplier_id']
    // 'Product_Code' => '1',
    // 'id'  => $item['product_id'],
// ]);
// if ($product->wasRecentlyCreated) {
    // $store = Products::create($result[0]);
        // $store = Products::create([
        //     'Product_Code' => $item['product_code'],
        //     // 'buy_price' => $item['buy_price'],
        //     // 'stock' => $item['stock'],
        //     // 'price_rec' => $item['price_rec'], 
        //     'brand' => $item['brand'],
        //     'name' => $item['name'],
        //     'category_id' => $item['category_id'],
        //     'buy_price' => $item['buy_price'],
        //     'price_rec' => $item['price_rec'],
        //     'price_rec_from_sup' => $item['price_rec_from_sup'],
        //     'Profit_Margin' => $item['Profit_Margin'],
        //     'Description' => $item['Description'],
        //     'Property' => $item['Property'],
        // ]);
        // return response()->json('$ada');
// }else {
    //   $store = Products::create([
        //     'Product_Code' => $item['product_code'],
        //     // 'buy_price' => $item['buy_price'],
        //     // 'stock' => $item['stock'],
        //     // 'price_rec' => $item['price_rec'], 
        //     'brand' => $item['brand'],
        //     'name' => $item['name'],
        //     'category_id' => $item['category_id'],
        //     'buy_price' => $item['buy_price'],
        //     'price_rec' => $item['price_rec'],
        //     'price_rec_from_sup' => $item['price_rec_from_sup'],
        //     'Profit_Margin' => $item['Profit_Margin'],
        //     'Description' => $item['Description'],
        //     'Property' => $item['Property'],
        // ]);
    // return response()->json('$item');
// }

// if(collect($data)){
//     $phone = $data->array_pluck($array, 'value');