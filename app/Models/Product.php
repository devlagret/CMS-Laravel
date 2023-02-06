<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'products';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'product_id',
        'product_code',
        'brand',
        'name',
        'category_id',
        'buy_price',
        'price_rec_from_sup',
        'price_rec',
        'profit_margin',
        'description',
        'property',
        'supplier_id',
    ];
}
