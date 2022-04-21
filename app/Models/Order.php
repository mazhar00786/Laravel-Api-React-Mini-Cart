<?php

namespace App\Models;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip_code',
        'payment_id',
        'payment_mode',
        'tracking_no',
        'status',
        'remark',
    ];

    /**
     * Get all of the order_items for the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderitems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
}
