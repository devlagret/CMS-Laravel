<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductRequest extends Model
{
    use SoftDeletes;

    protected $table = 'product_requests';
    protected $primaryKey = 'request_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'request_id',
        'branch_id',
        'product_code',
        'warehouse_id',
        'amount',
        'order_date',
        'out_date',
        'status',
    ];
}
