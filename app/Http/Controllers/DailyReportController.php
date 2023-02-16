<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\DailyReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DailyReportController extends Controller
{
    public function store(Request $request)
    {
        $validator = $this->validate($request, [
                'file'  => 'required|mimes:doc,docx,pdf,txt,json|max:2048',
        ]);
        if ($file = $request->file('file')) {
            $name = 'Daily Report'.Carbon::now();
            $path = $request->file('file')->move('public', $name.'.'.$file->extension());

            $bid = Branch::where('user_id', Auth::id())->first('branch_id');
            
            // if ($path) {
            //     DailyReport::create([
            //         'file_id' => Str::uuid()->toString(),
            //         'path'    => $path,
            //         'name'    => $name,
            //         'branch_id'=> $bid->branch_id
            //     ]);
            // }
              
            // return response()->json([
            //     "success" => true,
            //     "message" => "File successfully uploaded",
            //     "file" => $path
            // ]);
            return response()->json($path, 200);
        }
    }
}