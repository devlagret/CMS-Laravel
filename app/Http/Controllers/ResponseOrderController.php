<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResponseOrderController extends Controller
{
    public function index(Request $request)
    {
        $data = '604a80bc-18f9-4d28-9090-3fb42cdb4502';
        echo base_convert($data, 32, 2);
    }

}
