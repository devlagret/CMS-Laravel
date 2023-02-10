<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehousehResponseBranch extends Model
{
    protected $table = 'warehouseh_response_branches';

    protected $primaryKey = 'warehouse_response_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'warehouse_response_id', 'warehouse_id', 'branch_id', 'product_code', 'send_date', 'quantity',
    ];
    
}
