<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use SoftDeletes;
    protected $table = 'warehouses';
    protected $primaryKey = 'id';
    protected $fillable = [
        'warehouse_id', 'product_code', 'stock', 'entry_date', 'location',
    ];
}
