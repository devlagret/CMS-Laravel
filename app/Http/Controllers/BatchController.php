<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Log;
use App\Models\WhsDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BatchController extends Controller
{
    public function index(Request $request)
    {
        // if ($request->user()->cannot('viewAny', Batch::class)) {
        //     return response('Unauthorized', 401);
        // }
        $wid = WhsDetail::where('user_id', Auth::Id())->first();
        $batches = Batch::where('warehouse_id', $wid->warehouse_id)
        ->selectRaw('batches.*, SUM(stock) as total, products.name')
        ->groupBy('batches.product_code', 'status', 'exp_date')
        ->join('products', 'batches.product_code','=','products.product_code')
        ->get(['batches.*', 'products.name']);
        
        return response()->json($batches);
    }

    public function store(Request $request)
    {
        // if ($request->user()->cannot('create', Batch::class)) {
        //     return response('Unauthorized', 401);
        // }
        $validator = $this->validate($request, [ 
            'product_code' => 'required',
            'stock'        => 'required',
            'exp_date'     => 'required',
        ]);
        
        $wid = WhsDetail::where('user_id', Auth::Id())->first();
        $pc = $request->input('product_code');
        $stock = intval($request->input('stock'));
        $exp_date = $request->input('exp_date');
        $check = Batch::where('warehouse_id', $wid->warehouse_id)
                      ->where('product_code', $pc)
                      ->where('exp_date', $exp_date)
                      ->exists();

        if ($check) {
            Batch::where('warehouse_id', $wid->warehouse_id)
                ->where('product_code', $pc)
                ->where('exp_date', $exp_date)
                ->increment('stock', $stock);
            return response()->json(['message' => 'Stock Increase cause product is exist'], 200);
        }else {
            $batch = Batch::create([
                'batch_id'     => Str::uuid()->toString(),
                'warehouse_id' => $wid->warehouse_id,
                'product_code' => $pc,
                'stock'        => $stock,
                'exp_date'     => $exp_date,
                'entry_date'   => Carbon::today('Asia/Jakarta')->toDateString(),
            ]);
            return response()->json(['message' => 'Product Saved','data' => $batch], 201);
        }
        // return response()->json(intval($stock), 201);
    }

    public function checkExpired(Request $request)
    {
        // if ($request->user()->cannot('viewAny', Batch::class)) {
        //     return response('Unauthorized', 401);
        // }
        $wid = WhsDetail::where('user_id', Auth::Id())->first();
        $today_date = Carbon::today()->addDays(10)->toDateString();
        $batch = Batch::where('warehouse_id', $wid->warehouse_id)->get();
        foreach ($batch as $item) {
            if ($item['exp_date'] <= Carbon::today()->toDateString()) {
                Batch::where('warehouse_id', $wid->warehouse_id)
                ->where('batch_id', $item['batch_id'])
                ->update(['status' => 3]);
                $log = Log::create([
                    'user_id'   => Auth::id(),
                    'datetime'  => Carbon::now('Asia/Jakarta'),
                    'activity'  => 'Warehouse Expired(s)',
                    'detail'    => 'Product "'.$item['product_code'].'" with Stock "'.$item['stock'].'" in Warehouse "'.$wid->warehouse_id.'" Had Expired'
                
            ]);
            }elseif ($item['exp_date'] <= $today_date) {
                Batch::where('warehouse_id', $wid->warehouse_id)
                ->where('batch_id', $item['batch_id'])
                ->update(['status' => 2]);
                $log = Log::create([
                    'user_id'   => Auth::id(),
                    'datetime'  => Carbon::now('Asia/Jakarta'),
                    'activity'  => 'Warehouse Warning(s)',
                    'detail'    => 'Product "'.$item['product_code'].'" with Stock "'.$item['stock'].'" in Warehouse "'.$wid->warehouse_id.'" Almost Expired'
                    
                ]);
            }
        }
        return response()->json('Batch Updated');
        // return response()->json($batch);
    }

    public function getProduct(Request $request, $Code)
    {
        // if ($request->user()->cannot('viewAny', ProductOrder::class)) {
        //     return response('Unauthorized', 401);
        // }
        $stockups = Batch::where('product_code', $Code)
                         ->whereNot('status', 'Expired')->paginate(9);
        
        return response()->json($stockups);
    }
    
}
