<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id_product';

    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'product_name',
        'description',
        'price',
        'product_image',
        'stock',
        'id_category',
        'id_user',
        'product_status',
    ];

    public function category()
    {
        return $this->belongsTo(Product_categories::class, 'id_category', 'id_categories');
    }
}
