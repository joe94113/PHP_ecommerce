<?php

namespace App\Observers;

use App\Models\Product;
use App\Notifications\ProductReplenish;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function created(Product $product)
    {
        //
    }

    /**
     * Handle the Product "updated" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        $changes = $product->getChanges();  // 取得改變後的值
        $original = $product->getOriginal();  // 取得原始數值
        if (isset($changes['quantity']) && $product->quantity > 0 && $original['quantity'] == 0) {
            foreach ($product->favorite_users as $user) {  // 取得產品使用者
                $user->notify(new ProductReplenish($product));
            }
        }
    }

    /**
     * Handle the Product "deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        //
    }

    /**
     * Handle the Product "restored" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //
    }
}
