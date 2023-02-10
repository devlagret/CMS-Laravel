<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchRequestWarehouse extends Model
{
    protected $table = 'branch_request_warehouses';
    protected $keyType = 'string';
    protected $fillable = [
        'warehouse_id', 'request_id'
    ];
}
