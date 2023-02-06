<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseBatch extends Model
{
    protected $table = 'warehousebatches';
    protected $fillable = [
        'warehouse_id', 'batch_id', 'product_id', 'quantity', 'expired_date'
    ];
}
