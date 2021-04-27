<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // 資料庫模組
use App\Models\Cart;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // https://laravel.com/docs/8.x/migrations
        // $cart = DB::table('carts')->get()->first();
        // if (empty($cart)){  // 如果購物車是空的
        //     DB::table('carts')->insert(['created_at' => now(), 'updated_at' => now()]);  // now():現在時間
        //     $cart = DB::table('carts')->get()->first();
        // }
        // $cartItems = DB::table('cart_items')->where('cart_id', $cart->id)->get();  // 抓取cart_id=cart id的資料
        // $cart = collect($cart);
        // $cart['items'] = collect($cartItems);
        $user = auth()->user();
        $cart = Cart::with(['cartItems'])->where('user_id', $user->id)
                                        ->where('checkouted', false)
                                        ->firstOrCreate(['user_id' => $user->id]);  // 如果不存在則新增，with()根據對應資料一起撈出來
        return response($cart);

    }

    public function checkout()
    {
        $user = auth()->user();  // 取得結帳user
        $cart = $user->carts()->where('checkouted', false)->with('cartItems')->first();
        if ($cart){
            $result = $cart->checkout();
            return response($result);
        }
        else {
            return response('沒有購物車', 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
