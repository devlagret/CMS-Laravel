<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    protected $table = 'product_order';

    protected $primaryKey = 'product_order_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'product_order_id', 'supplier_id','product_code','purchase_date','total_amount','quantity'
    ];
    
}
