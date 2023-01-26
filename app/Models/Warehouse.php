<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $table = 'warehouses';
    protected $primaryKey = 'id';
    protected $fillable = [
        'warehouse_id',
        'product_code',
        'stock',
        'entry_date',
        'location',
    ];
}
