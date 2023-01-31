<?php

namespace App\Http\Controllers;

use App\Models\Product as product;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    
    public function index()
    {
        $products = Product::get();
        $user = Auth::check();
        return response()->json([$user,$products]);
    }

    public function store(Request $request)
    {
        $validator = $this->validate($request, [
            'product_code'        => 'required',
            'brand'               => 'required',
            'name'                => 'required',
            'category_id'         => 'required',
            'buy_price'           => 'required',
            'price_rec'           => 'required',
            'price_rec_from_sup'  => 'required',
            'description'         => 'required',
            'property'            => 'required',
            'supplier_id'         => 'required',
        ]);
        $p_code = $request->input('product_code');
        $cateid = $request->input('category_id');
        $data = Product::where('product_id', 'like', $cateid . '%')->orderBy('product_id', 'desc')->first('product_id');
        $data = json_encode(array($data), JSON_NUMERIC_CHECK);
        $data = intval(preg_replace('/[^0-9]/', '', $data));
        $data = $data+1;
        $Val = ($data < 100) ? (($data < 10) ? '00'.$data : '0'.$data) : $data ;
        $pid = $cateid .'-'. $Val;


        throw_if(
            $p_code === 0 && $p_code <= 0,
            new \InvalidArgumentException('Product Code is Empty')
        );

        $product = product::create([
            'id'                  => Str::uuid()->toString(),
            'product_id'          => $pid,
            'product_code'        => $p_code,
            'brand'               => $request->input('brand'),
            'name'                => $request->input('name'),
            'category_id'         => $cateid,
            'buy_price'           => $request->input('buy_price'),
            'price_rec'           => $request->input('price_rec'),
            'price_rec_from_sup'  => $request->input('price_rec_from_sup'),
            'profit_margin'       => $request->input('profit_margin'),
            'description'         => $request->input('description'),
            'property'            => $request->input('property'),
            'supplier_id'         => $request->input('supplier_id'),
        ]);
        $uh = new UserHelper;
        if ($product) {
            Log::create([
                'user_id' => $uh->getUserData($request->header('token'))->user_id,
                'datetime' => Carbon::now('Asia/Jakarta'),
                'activity' => 'Add Product(s)',
                'detail' => 'New Product '.$p_code.'has Been Added'
            ]);
            return response()->json(['message' => 'Data added successfully'], 201);
        }else {
            return response()->json("Failure",500);
        }
    }

    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response('Product Not Found',404);}
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $validator = $this->validate($request, [
            'product_code'        => 'required',
            'brand'               => 'required',
            'name'                => 'required',
            'category_id'         => 'required',
            'buy_price'           => 'required',
            'price_rec'           => 'required',
            'price_rec_from_sup'  => 'required',
            'profit_margin'       => 'required',
            'description'         => 'required',
            'property'            => 'required',
            'supplier_id'         => 'required',
        ]);
        $product_code = $request->input('product_code');

        $product = product::whereId($id)->update([
            'product_code'       => $request->input('product_code'),
            'brand'              => $request->input('brand'),
            'name'               => $request->input('name'),
            'category_id'        => $request->input('category_id'),
            'buy_price'          => $request->input('buy_price'),
            'price_rec'          => $request->input('price_rec'),
            'price_rec_from_sup' => $request->input('price_rec_from_sup'),
            'profit_margin'      => $request->input('profit_margin'),
            'description'        => $request->input('description'),
            'property'           => $request->input('property'),
            'supplier_id'        => $request->input('supplier_id'),
            
        ]);
        $uh = new UserHelper;
        if ($product) {
            Log::create([
                'user_id' => $uh->getUserData($request->header('token'))->user_id,
                'datetime' => Carbon::now('Asia/Jakarta'),
                'activity' => 'Update Product(s)',
                'detail' => 'Update Product information with Code '.$product_code
            ]);
            return response()->json(['message' => 'Data added successfully'], 201);
        }else {
            return response()->json("Failure");
        }
    }

    public function destroy($id)
    {
        Product::destroy($id);

        return response()->json(['message' => 'Deleted']);
    }

    public function category($id){
        $p = Product::where('id',$id)->first();
        if (!$p) {
            return response('Product Not Found', 404);
        }
        $c = Category::where('category_id', $p->category_id)->first();
        return response()->json($c);
    }
    public function supplier($id){
        $p = Product::where('id', $id)->first();
        if (!$p) {
            return response('Product Not Found', 404);
        }
        $s = Supplier::where('supplier_id', $p->supplier_id)->first();
        return response()->json($s);
    }
}
