<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductOrder extends Model
{
    use SoftDeletes;
    protected $table = 'product_order';

    protected $primaryKey = 'product_order_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'product_order_id', 'supplier_id','product_code','purchase_date','total_amount','quantity','product_expired'
    ];
    
}
