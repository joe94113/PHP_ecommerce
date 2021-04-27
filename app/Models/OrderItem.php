<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $guarded = [''];  // 所有欄位可更改
    public function product(){
        return $this->belongsTo(Product::class);  // 複數資料
    }
    
    public function order(){
        return $this->belongsTo(Order::class);
    }
}
