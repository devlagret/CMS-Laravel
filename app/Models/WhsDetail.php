<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WhsDetail extends Model
{
    use SoftDeletes;
    protected $table = 'whs_detail';

    protected $primaryKey = 'warehouse_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'warehouse_id','user_id','manager_name','contact','adress'
    ];
}
