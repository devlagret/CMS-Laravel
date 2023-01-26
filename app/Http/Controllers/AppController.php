<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;

class AppController extends Controller
{
    //
    public function profile(Request $request){
        if($request->isMethod('GET')){
            $data = Config::select('key','value')->where('type', 'profile')->orderBy('key','desc')->get();
            $d = array();
            foreach($data as $da){
                $d[$da->key] = $da->value;
            }
            //var_dump($data);
            return response()->json($d
        );
        }
        if ($request->isMethod('PUT')) {
            //$this->validate($request, [
            //    'key' => 'required|max:10',
            //    'value' => 'required|max:100'
            //]);
            $f = $request->input();
            foreach ( $f as $k => $v){
            $data = Config::where([['type', 'profile'],['key',$k]])->first();
            if($data){
                $data->update(['value' =>$v]);
                return response()->json(['message' => 'Data updated  successfully'], 201);
            }
            return response()->json(['message' => 'Data with key "'.$k.'" not found',401]);
        }
        }
        return response('Forbiden Method', 403);

    }
}
