<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Product::create(['title'=>'測試資料1', 'content'=>'測試內容1', 'price'=>rand(0, 300), 'quantity'=>20]);
        Product::create(['title'=>'測試資料2', 'content'=>'測試內容2', 'price'=>rand(0, 300), 'quantity'=>20]);
        Product::create(['title'=>'測試資料3', 'content'=>'測試內容3', 'price'=>rand(0, 300), 'quantity'=>20]);

        $this->call(ProductSeeder::class);  // call ProductSeeder執行
        $this->command->info('產生固定Products資料');  // 在shell產生信息
    }
}
