<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $productCount = Product::count();
        $dataPerPage = 2;
        $productPages = ceil($productCount / $dataPerPage);  // ceil()無條件進位
        $currentPage = isset($request->all()['page']) ? $request->all()['page'] : 1;  // 前端如果有帶page參數就顯示那頁沒有就1
        $products = Product::orderBy('created_at', 'asc')  // 利用with遇載資料庫優化效能
            ->offset($dataPerPage * ($currentPage - 1))  // 資料從第幾筆開始顯示
            ->limit($dataPerPage)  // 一頁顯示資料限制
            ->get();

        return view('admin.products.index', [
            'products' => $products,
            'productCount' => $productCount,
            'productPages' => $productPages
        ]);
    }

    public function uploadImage(Request $request)
    {
        // dd($request);
        $file = $request->file('product_image');
        $productId = $request->input('product_id', null);

        if (is_null($productId)) {  // 如果找不到檔案
            return redirect()->back()->withErrors(['mag' => '參數錯誤']);  // 停在原本位置，前端會收到$errors
        }
        $product = Product::find($productId);
        $path = $file->store('public/images');  // 儲存到store/app/images裡面
        $product->images()->create([
            'filename' => $file->getClientOriginalName(),  // 取得當初使用者上傳檔名
            'path' => $path
        ]);
        return redirect()->back();  // 回到前一頁=保持同一頁
    }
}
