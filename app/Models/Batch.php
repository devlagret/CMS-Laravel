<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $table = 'batches';
    protected $primaryKey = 'batch_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
      'batch_id', 'entry_date'
    ];
}
