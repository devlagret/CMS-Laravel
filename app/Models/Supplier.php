<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'suppliers';

    protected $primaryKey = 'supplier_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'supplier_id','supplier_name', 'contact', 'address'
    ];
}
