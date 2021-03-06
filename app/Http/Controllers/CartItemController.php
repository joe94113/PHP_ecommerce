<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // 資料庫模組
use Illuminate\Support\Facades\Validator;  // 資料驗證套件:https://laravel.com/docs/8.x/validation#introduction
use App\Http\Requests\UpdateCartItem;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)  // create
    {
        $messages = [  // 更改警告訊息
            'required' => ':attribute 是必要的',
            'between' => ':attribute 的輸入 :input 不在 :min 和 :max 之間'
        ];

        $Validator = Validator::make($request->all(), [  // 創立驗證者設定規則
            'cart_id' => 'required|integer',  // 欄位必填
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|between:1, 10'  // 數量1~10
        ], $messages);  

        if ($Validator->fails()){  //如果驗證沒有通過
            return response($Validator->errors(), 400);
        }

        $ValidateData = $Validator->validate();  // 取得驗證後資料
        
        $product = Product::find($ValidateData["product_id"]);
        if (!$product->checkQuantity($ValidateData['quantity'])){
            return response($product->title.'數量不足', 400);
        }

        $cart = Cart::find($ValidateData['cart_id']);
        $result = $cart->cartItems()->create(['product_id' => $product->id,
                                                'quantity' => $ValidateData['quantity']]);
        // DB::table('cart_items')->insert();
        return response()->json($result);
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
    public function update(UpdateCartItem $request, $id)
    {
        $form = $request->validated();  // 獲取前端傳來表單
        $item = CartItem::find($id);  // 找到cart_items ID
        $item->fill(['quantity' => $form['quantity']]);  // fill()填好不儲存，可增加效能
        // $item->update(['quantity' => $form['quantity']]);  // 也可直接使用update
        $item->save();
        return response()->json($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = CartItem::find($id);  // 找到對應id修改
        // 使用CartItem::withTrashed()->find($id)->forceDelete();就會使用sql語法真正刪除
        $item->delete();
        return response()->json(true);
    }
}
