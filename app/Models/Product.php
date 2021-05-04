<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function favorite_users()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function checkQuantity($quantity)
    {
        if ($this->quantity < $quantity) {  // 如果輸入的數量大於商品數量回傳
            return false;
        }
        return true;
    }
}
