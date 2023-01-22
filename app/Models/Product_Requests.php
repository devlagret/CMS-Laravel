<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_Requests extends Model
{

    protected $table = 'product_requests';
    protected $primaryKey = 'request_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'request_id',
        'branch_id',
        'product_code',
        'amount',
        'order_date',
        'out_date',
        'status',
    ];
}
