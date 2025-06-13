<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'id_order';

    protected $fillable = [
        'id_user',
        'id_payment',
        'order_status',
        'order_date',
        'shipping'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'id_payment');
    }

    public function orderDetails()
    {
        return $this->hasMany(Order_detail::class, 'id_order');
    }
}
