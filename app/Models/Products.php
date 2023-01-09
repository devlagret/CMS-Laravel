<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        'Product_Code',
        'Brand',
        'Name',
        'type',
        'category_id',
        'buy_price',
        'Price_Recomendation_from_Sup',
        'Price_Recomendation',
        'Profit_Margin',
        'Entry_Date',
        'Out_Date',
        'Expiration_Date',
        'Description',
        'Property',
        'supplier_id',
    ];
}
