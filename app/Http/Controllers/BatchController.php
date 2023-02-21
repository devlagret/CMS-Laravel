<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\WhsDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isEmpty;

class BatchController extends Controller
{
    public function index(Request $request)
    {
        // if ($request->user()->cannot('viewAny', Batch::class)) {
        //     return response('Unauthorized', 401);
        // }
        $wid = WhsDetail::where('user_id', Auth::Id())->first();
        $batches = Batch::where('warehouse_id', $wid->warehouse_id)->paginate(9);
        
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
        $today_date = Carbon::today()->addDays(2)->toDateTimeString();
        $batch = Batch::where('exp_date', '<=', $today_date)->get();
        
        return response()->json($batch);
    }
}
