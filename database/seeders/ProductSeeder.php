<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::upsert([  // 告訴他更新資料試甚麼
            ['id'=>6, 'title'=>'固定資料1', 'content'=>'固定內容1', 'price'=>rand(0, 300), 'quantity'=>20],
            ['id'=>7, 'title'=>'固定資料2', 'content'=>'固定內容222', 'price'=>rand(0, 300), 'quantity'=>20],
        ], ['id'], ['price', 'quantity']);  // 第二個參數試primary key，如果ID存在則更新，不在則建立(只更新price or quantity)
    }
}
