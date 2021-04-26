<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $guarded = [''];  // 所有欄位可更改
    protected $appends = ["current_price"];  // 自製屬性

    public function getCurrentPriceAttribute()  // 固定命名規則get...Attribute對應上面自製屬性
    {
        return $this->quantity * 10;  // 執行程式 CartItem::find(1)->current_price，就會執行這段function
    }

    public function product(){
        return $this->belogsTo(Product::class);
    }

    public function cart(){
        return $this->belogsTo(Cart::class);
    }
}
