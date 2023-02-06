<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchProduct extends Model
{
    protected $table = 'batchproducts';
    protected $fillable = [
        'batch_id', 'product_id'
    ];
}
