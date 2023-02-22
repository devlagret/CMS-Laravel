<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelper;
use App\Models\Batch as ModelsBatch;
use App\Models\Category;
use App\Models\Log;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\ProductOrderRequest;
use App\Models\RequestOrder;
use App\Models\ResponseOrder;
use App\Models\SendedProduct;
use App\Models\Token;
use App\Models\User;
use Illuminate\Bus\Batch;
use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\WhsDetail;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use stdClass;
use Symfony\Component\VarDumper\VarDumper;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->can('view', Warehouse::class)) {
            $warehouses = Warehouse::paginate(9);
        }elseif ($request->user()->can('viewAny', Warehouse::class)) {
            $wid       = WhsDetail::where('user_id', Auth::id())->first();
            $warehouses = Warehouse::where('warehouse_id', $wid->warehouse_id)
                                   ->paginate(9);
        }else {
            return response('Unauthorized', 401);
        }
        return response()->json($warehouses);
    }
    
    public function store(Request $request)
    {
        if ($request->user()->cannot('create', Warehouse::class)) {
            return response('Unauthorized', 401);
        }
        $validator = $this->validate($request, [
            'product_code'  => 'required',
            'stock'         => 'required|max:15',
            'location'      => 'required',
        ]);
        
        $product_code = $request->input('product_code');
        $amount       = $request->input('stock');
        $entry_date   = $request->input('entry_date');
        $wid          = WhsDetail::where('user_id', Auth::id())->first();
        $exp_date     = $request->input('exp_date');
        $check = Warehouse::where('warehouse_id', $wid->warehouse_id)
            ->where('product_code', $product_code)
            ->exists();

        if ($check) {
            return response()->json(['message' => 'Product is Exist'], 400);
        }
        $warehouse = Warehouse::create([
            'warehouse_id'  => $wid->warehouse_id,
            'product_code'  => $request->input('product_code'),
            'stock'         => $request->input('stock'),
            'entry_date'    => is_null($entry_date) ? Carbon::today('Asia/Jakarta')->toDateString() : $entry_date,
            'location'      => $request->input('location'),
        ]);

        if ($warehouse) {
            // Batch::create([
            //     'batch_id'     => Str::uuid()->toString(),
            //     'warehouse_id' => $wid->warehouse_id,
            //     'product_code' => $product_code,
            //     'stock'        => $amount,
            //     'exp_date'     => $exp_date,
            //     'entry_date'   => Carbon::today('Asia/Jakarta')->toDateString(),
            // ]);
            Log::create([
                'user_id'   => Auth::id(),
                'datetime'  => Carbon::now('Asia/Jakarta'),
                'activity'  => 'Warehouse(s)',
                'detail'    => 'User "'.Auth::id().'" Add Product "'.$product_code.'" to Warehouse "'.$wid->warehouse_id
            ]);
            return response()->json(['message' => 'Data added successfully','Data'=> $warehouse], 201);
        }else {
            return response()->json("Failure",500);
        }
    }

    public function show(Request $request, $id)
    {
        if ($request->user()->cannot('view', Warehouse::class)&&$request->user()->cannot('viewAny', Warehouse::class)) {
            return response('Unauthorized', 401);
        }
        $warehouse = Warehouse::find($id);
        if (!$warehouse) {
            return response()->json('Data Not Found', 404);
        }
        return response()->json($warehouse);
    }

    public function showProduct(Request $request, $productCode)
    {
        if ($request->user()->cannot('view', Warehouse::class)&&$request->user()->cannot('viewAny', Warehouse::class)) {
            return response('Unauthorized', 401);
        }
        $a = array();
        $warehouse = Warehouse::where('product_code', $productCode)
                            ->join('whs_detail','warehouses.warehouse_id','=','whs_detail.warehouse_id')
                            ->get(['warehouses.warehouse_id', 'stock','name','adress','contact']);        
        return response()->json($warehouse);
    }

    public function showStock(Request $request, $productCode, $stock)
    {
        if ($request->user()->cannot('viewStock', Warehouse::class)) {
            return response('Unauthorized', 401);
        }
        $warehouse = Warehouse::where('product_code', $productCode)
                              ->where('stock', '>=', $stock+10)
                              ->get(['warehouse_id', 'stock']);
        if (count($warehouse) < 1) {
            $warehouse = Warehouse::where('product_code', $productCode)
                              ->get('warehouse_id');
            return response()->json(['message' => 'Currently the stock in the warehouse is less than your request','data' => $warehouse]);
        }
        return response()->json($warehouse);
    }

    public function showEachWarehouse(Request $request)
    {
        if ($request->user()->cannot('view', Warehouse::class)) {
            return response('Unauthorized', 401);
        }
        $validator = $this->validate($request, [
            'warehouse_id' => 'required',
        ]);
        $w = $request->input('warehouse_id');

        $warehouse = Warehouse::where('warehouse_id', $w)->get();
        return response()->json($warehouse);
    }

    public function productInWarehouse(Request $request)
    {
        if ($request->user()->can('view', Warehouse::class)) {
            $warehouse = Warehouse::get('product_code');
            $product = Product::whereIn('product_code', $warehouse)->get(['product_code', 'name']);
            return response()->json($product);
        }elseif ($request->user()->can('viewAny', Warehouse::class)) {
            $wid = WhsDetail::where('user_id', Auth::id())->first();
            $warehouse = Warehouse::where('warehouse_id', $wid->warehouse_id)->get('product_code');
            $product = Product::whereIn('product_code', $warehouse)->get(['product_code', 'name']);
            return response()->json($product);
        }else {
            return response('Unauthorized', 401);
        }
    }

    public function productNameInWarehouse(Request $request)
    {
        if ($request->user()->cannot('view', Warehouse::class)) {
            $name = $request->input('name');
            $warehouse = Warehouse::get('product_code');
            $product = Product::whereIn('product_code', $warehouse)
                            ->where('name', 'LIKE', '%'.$name.'%')
                            ->get(['product_code','name']);
            return response()->json($product);
        }elseif ($request->user()->cannot('viewAny', Warehouse::class)) {
            $name = $request->input('name');
            $wid = WhsDetail::where('user_id', Auth::id())->first();
            $warehouse = Warehouse::where('warehouse_id', $wid->warehouse_id)->get('product_code');
            $product = Product::whereIn('product_code', $warehouse)
                            ->where('name', 'LIKE', '%'.$name.'%')
                            ->get(['product_code','name']);
            return response()->json($product);
        }else {
            return response('Unauthorized', 401);
        }
    }

    public function getSendedProduct(Request $request)
    {
        if ($request->user()->cannot('viewAny', Warehouse::class)) {
            return response('Unauthorized', 401);
        }
        $validator = $this->validate($request, [
            'warehouse_id' => 'required',
        ]);
        $w = $request->input('warehouse_id');

        $warehouse = SendedProduct::where('warehouse_id', $w)->get();
        return response()->json($warehouse);
    }

    public function update(Request $request, $id)
    {
        if ($request->user()->cannot('update', Warehouse::class)) {
            return response('Unauthorized', 401);
        }
        $validator = $this->validate($request, [
            'product_code'  => 'required',
            'stock'         => 'required|max:15',
            'location'      => 'required',
        ]);
        
        $product_code = $request->input('product_code');
        $wid          = WhsDetail::where('user_id', Auth::id())->first();

        $warehouse = Warehouse::whereId($id)->update([
            'warehouse_id'  => $wid->warehouse_id,
            'product_code'  => $request->input('product_code'),
            'stock'        => $request->input('stock'),
            'location'      => $request->input('location'),
            'entry_date'        => Carbon::today('Asia/Jakarta')->toDateString(),
        ]);

        if ($warehouse) {
            Log::create([
                'user_id'   => Auth::id(),
                'datetime'  => Carbon::now('Asia/Jakarta'),
                'activity'  => 'Warehouse(s)',
                'detail'    => 'User "'.Auth::id().'" update Product "'.$product_code.'" in Warehouse "'.$wid->warehouse_id
            ]);
            return response()->json(['message' => 'Data updated successfully'], 201);
        }else {
            return response()->json("Failure");
        }
    }

    public function updateStock(Request $request)
    {
        if ($request->user()->cannot('update', Warehouse::class)) {
            return response('Unauthorized', 401);
        }
        // $validator = $this->validate($request, [
        //     'product_code'  => 'required',
        //     'stock'         => 'required|max:15',
        //     'location'      => 'required',
        // ]);
    
        $wid   = WhsDetail::where('user_id', Auth::id())->first();
        $batch = ModelsBatch::where('warehouse_id', $wid->warehouse_id)->get();
        foreach ($batch as $item) {
            $warehouse = Warehouse::where('warehouse_id', $item['warehouse_id'])
                                ->where('product_code', $item['product_code'])
                                ->update(['stock' => $item['stock']]);
        }

        // if ($warehouse) {
        //     // Log::create([
        //     //     'user_id'   => Auth::id(),
        //     //     'datetime'  => Carbon::now('Asia/Jakarta'),
        //     //     'activity'  => 'Warehouse(s)',
        //     //     'detail'    => 'User "'.Auth::id().'" update Product "'.$product_code.'" in Warehouse "'.$wid->warehouse_id
        //     // ]);
        //     return response()->json(['message' => 'Data updated successfully'], 201);
        // }else {
        //     return response()->json("Failure");
        // }
    }
    
    public function stockup(Request $request, $product_code)
    {
        if ($request->user()->cannot('update', Warehouse::class)) {
            return response('Unauthorized', 401);
        }
        $pid = $request->input('product_order_requests_id');
        
        $wid = WhsDetail::where('user_id', Auth::id())->first();
        $stock = ResponseOrder::where('product_order_requests_id', $pid)
                            ->first();
        
        if (!$request->filled('product_order_requests_id')) {
            $warehouse = Warehouse::where('warehouse_id',$wid->warehouse_id)
                                ->where('product_code',$product_code)
                                ->increment('stock', $stock->quantity);
            
            return response()->json($warehouse);
        }
        return response()->json($stock);
    }

    public function destroy(Request $request, $id)
    {
        if ($request->user()->cannot('delete', Warehouse::class)) {
            return response('Unauthorized', 401);
        }
        Warehouse::destroy($id);

        return response()->json(['message' => 'Deleted']);
    }

    public function trash(Request $request, $id = null)
    {
        if ($request->user()->cannot('viewAny', User::class)) {
            return response('Unauthorized', 401);
        }
        if ($id != null) {
            $trash = Warehouse::onlyTrashed()->find($id);
            if (!$trash) {
                return response('Id Not Found', 404);
            }
            if ($trash->isEmpty()) {
                return response('No Warehouse Trased', 404);
            }
            return response()->json($trash);
        }
        $trash = Warehouse::onlyTrashed()->get();
        if ($trash->isEmpty()) {
            return response('No Warehouse Trased', 404);
        }
        return response()->json($trash);
    }
    public function restore(Request $request)
    {
        if ($request->user()->cannot('viewAny', Warehouse::class)) {
            return response('Unauthorized', 401);
        }
        $this->validate($request, ['warehouse' => 'required|min:36']);
        $id = explode(",", str_replace(" ", "", $request['warehouse']));
        $restore = Warehouse::whereIn('warehouse', $id)->restore();
        if (!$restore) {
            return response('Failure', 500);
        }
        return response('Restore Sucess');
    }
    public function restoreAll(Request $request)
    {
        if ($request->user()->cannot('viewAny', Warehouse::class)) {
            return response('Unauthorized', 401);
        }
        $restore = Warehouse::onlyTrashed()->restore();
        if (!$restore) {
            return response('Failure', 500);
        }
        return response('Restore Sucess');
    }
    public function delete(Request $request)
    {
        if ($request->user()->cannot('viewAny', Warehouse::class)) {
            return response('Unauthorized', 401);
        }
        if ($request->isMethod('DELETE')) {
            $delete = Warehouse::onlyTrashed()->forceDelete();
            if (!$delete) {
                return response('Failure', 500);
            }
            return response('Restore Sucess');
        }
        if ($request->isMethod('POST')) {
            $this->validate($request, ['warehouse' => 'required|min:36']);
            $id = explode(",", str_replace(" ", "", $request['warehouse']));
            $delete = Warehouse::whereIn('warehouse', $id)->forceDelete();
            if (!$delete) {
                return response('Failure', 500);
            }
            return response('Restore Sucess');
        }
        return response('Forbiden Method', 403);
    }
}