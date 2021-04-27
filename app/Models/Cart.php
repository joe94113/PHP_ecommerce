<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = [''];  // 所有欄位可更改
    private $rate = 1;
    public function cartItems(){
        return $this->hasMany(CartItem::class);  // 複數資料
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function order(){
        return $this->hasOne(Order::class);
    }

    public function checkout()
    {
        foreach($this->cartItems as $cartItem){
            $product = $cartItem->product;
            if(!$product->checkQuantity($cartItem->quantity)){
                return $product->title.'數量不足';
            }
        }

        $order = $this->order()->create([
            'user_id' => $this->user_id
        ]);
        
        if($this->user->level == 2){
            $this->rate = 0.8;  // 是vip打八折
        }

        foreach($this->cartItems as $cartItem){
            $order->orderItems()->create([
                'product_id' => $cartItem->product_id,
                'price' => $cartItem->product->price * $this->rate
            ]);
            $cartItem->product->update(['quantity' => $cartItem->product->quantity - $cartItem->quantity]);  // 減掉產品數量
        }
        $this->update(['checkouted' => true]);  // 表示購物車已結帳
        $order->orderItems;  // 也撈orderItems資料
        return $order;  // 回傳訂單樣子
    }
}
