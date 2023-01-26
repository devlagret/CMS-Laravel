<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
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
