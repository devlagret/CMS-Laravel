<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelper;
use App\Models\Category;
use App\Models\Log;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\ProductOrderRequest;
use App\Models\RequestOrder;
use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\WhsDetail;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use stdClass;
use Symfony\Component\VarDumper\VarDumper;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->cannot('viewAny', Warehouse::class)) {
            return response('Unauthorized', 401);
        }
        $warehouses = DB::table('warehouses')->simplePaginate(10);
        
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

        $warehouse = Warehouse::create([
            'warehouse_id'  => $wid->warehouse_id,
            'product_code'  => $request->input('product_code'),
            'stock'        => $request->input('stock'),
            'entry_date'    => is_null($entry_date) ? Carbon::today('Asia/Jakarta')->toDateString() : $entry_date,
            'location'      => $request->input('location'),
        ]);

        if ($warehouse) {
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
        return response()->json($warehouse);
    }

    public function showProduct(Request $request, $productCode)
    {
        if ($request->user()->cannot('view', Warehouse::class)&&$request->user()->cannot('viewAny', Warehouse::class)) {
            return response('Unauthorized', 401);
        }
        $warehouse = Warehouse::where('product_code', $productCode)->get(['warehouse_id', 'stock']);
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
            'branch_id'     => $request->input('branch_id'),
            'product_code'  => $request->input('product_code'),
            'amount'        => $request->input('amount'),
            'order_date'    => $request->input('order_date'),
            'out_date'      => $request->input('out_date'),
            'status'        => $request->input('status'),
        ]);

        if ($warehouse) {
            Log::create([
                'user_id'   => Auth::id(),
                'datetime'  => Carbon::now('Asia/Jakarta'),
                'activity'  => 'Warehouse(s)',
                'detail'    => 'User "'.Auth::id().'" update Product "'.$product_code.'" in Warehouse "'.$wid->warehouse_id
            ]);
            return response()->json(['message' => 'Data added successfully'], 201);
        }else {
            return response()->json("Failure");
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($request->user()->cannot('delete', Warehouse::class)) {
            return response('Unauthorized', 401);
        }
        Warehouse::destroy($id);

        return response()->json(['message' => 'Deleted']);
    }

    public function stockup(Request $request, $product_code)
    {
        if ($request->user()->cannot('update', Warehouse::class)) {
            return response('Unauthorized', 401);
        }
        $pid = $request->input('product_order_requests_id');
        
        $wid = WhsDetail::where('user_id', Auth::id())->first();
        $stock = RequestOrder::where('product_order_requests_id', $pid)
                            ->first();
        
        if (!$request->filled('product_order_requests_id')) {
            $warehouse = Warehouse::where('warehouse_id',$wid->warehouse_id)
                                ->where('product_code',$product_code)
                                ->increment('stock', $stock->quantity);
            
            return response()->json($warehouse);
        }
        return response()->json($stock);
        
        
        
        
        
    }
}