<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    protected $fillable = [
        'supplier_name', 'contact', 'address'
    ];
}
