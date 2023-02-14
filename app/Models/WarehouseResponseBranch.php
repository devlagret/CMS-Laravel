<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseResponseBranch extends Model
{
    protected $table = 'warehouse_response_branches';

    protected $primaryKey = 'warehouse_response_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'warehouse_response_id', 'warehouse_id', 'branch_id', 'product_code', 'send_date', 'quantity',
    ];
    
}
