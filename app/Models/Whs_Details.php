<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Whs_Details extends Model
{
    protected $table = 'whs_detail';

    protected $primaryKey = 'warehouse_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'user_id','warehouse_id','manager_name','contact','adress'
    ];
}
