<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_categories extends Model
{
    use HasFactory;

    protected $table = 'product_categories';
    protected $primaryKey = 'id_categories';

    protected $fillable = [
        'name_categories'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'id_category');
    }
}
