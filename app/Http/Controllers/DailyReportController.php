<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\DailyReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class DailyReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('Cors', ['except' => ['getDownload']]);
    }
    public function index(Request $request)
    {
        
    }

    public function store(Request $request)
    {
        $validator = $this->validate($request, [
                'file'  => 'required|mimes:doc,docx,pdf,txt,json|max:2048',
        ]);

        if ($file = $request->file('file')) {
            $name = Carbon::today('Asia/Jakarta')->toDateString().'_'.'daily_report'.'.'.$file->extension();
            $path = 'public';
            $request->file('file')->move('public',$name);

            $bid = Branch::where('user_id', Auth::id())->first();
        }
        DailyReport::create([
            'file_id' => Str::uuid()->toString(),
            'path'    => $path,
            'name'    => $name,
            'branch_id'=> $bid->branch_id,
        ]);
    
    return response()->json([
        "success" => true,
        "message" => "File successfully uploaded",
        "file" => $file
    ]);
    }

    public function getDownload()
    {
        //PDF file is stored under project/public/download/info.pdf
        $path = 'public/APP Grosir - prototype.txt';
        $name = '2023-02-16_daily_report.json';
        $headers = [
                'Content-Type: application/pdf',
        ];

        return Response()->download($path);

        // $type = 'text/plain';
        // $headers = ['Content-Type' => 'text/plain'];
        // $path = 'public/2023-02-16_daily_report.txt';

        // $response = new BinaryFileResponse($path, 200 , $headers);

        // return $response;
    }
}
