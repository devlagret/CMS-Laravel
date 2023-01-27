<?php

namespace App\Http\Controllers;

use App\Models\Permision;
use Illuminate\Http\Request;

class PermisionController extends Controller
{
    //
    public function index(){
        $permision = Permision::orderBy('group')->get(['permision_id','label as name','group']);
        return response()->json($permision);
    }
}
