<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelper;
use App\Models\Log;
use App\Models\Warehouse;
use App\Models\WhsDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WhsDetailController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->cannot('viewAny', WhsDetail::class)) {
            return response('Unauthorized', 401);
        }
        $batches = WhsDetail::paginate(9);
        
        return response()->json($batches);
    }
    public function store(Request $request)
    {
        if ($request->user()->cannot('create', WhsDetail::class)) {
            return response('Unauthorized', 401);
        }
        $validator = $this->validate($request, [
            'manager_name'  => 'required',
            'contact'       => 'required|max:15',
            'adress'        => 'required',
            'user_id'       => 'required',
        ]);
        
        $whsdetail = WhsDetail::create([
            'warehouse_id'  => Str::uuid()->toString(),
            'user_id'       => $request->input('user_id'),
            'manager_name'  => $request->input('manager_name'),
            'contact'       => $request->input('contact'),
            'adress'    => $request->input('adress'),
        ]);
        
        $uh = new UserHelper;
        if ($whsdetail) {
            Log::create([
                'uid'       => Auth::id(),
                'datetime'  => Carbon::now('Asia/Jakarta'),
                'activity'  => 'Product Request(s)',
                'detail'    => 'Detail Warehouse Added '
            ]);
            return response()->json(['message' => 'Data added successfully'], 201);
        }else {
            return response()->json("Failure");
        }
        // return response()->json($whsdetail);
    }
    public function showEachWarehouse(Request $request, $id)
    {
        if ($request->user()->cannot('view', Warehouse::class)) {
            return response('Unauthorized', 401);
        }

        $warehouse = Warehouse::where('warehouse_id', $id)->get();
        return response()->json($warehouse);
    }
}
