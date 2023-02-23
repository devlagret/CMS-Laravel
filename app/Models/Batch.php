<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Batch extends Model
{
  use SoftDeletes;
    protected $table = 'batches';
    protected $primaryKey = 'batch_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
    'batch_id', 'warehouse_id', 'product_code', 'stock', 'exp_date', 'entry_date', 'status'
    ];
}
