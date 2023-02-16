<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\DailyReport;
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
            $path = $file->store('public');
            $name = $file->getClientOriginalName();
 
            $save = new DailyReport();
            $save->name = $file;
            $save->path= $path;
            $save->save();

            if ($save) {
                DailyReport::create([
                    'file_id' => Str::uuid()->toString(),
                    'path'    => $path,
                    'name'    => $name,
                    'batch_id'=> Branch::where('user_id', Auth::id())->first('batch_id')
                ]);
            }
              
            return response()->json([
                "success" => true,
                "message" => "File successfully uploaded",
                "file" => $file
            ]);
        }
    }
}
