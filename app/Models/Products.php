<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $primaryKey = 'id';

    protected $fillable = [
        'Product_Code',
        'Brand',
        'Name',
        'type',
        'category_id',
        'buy_price',
        'price_rec_from_sup',
        'price_rec',
        'Profit_Margin',
        // 'Entry_Date',
        // 'Out_Date',
        // 'Expiration_Date',
        'Description',
        'Property',
        'supplier_id',
    ];
}
