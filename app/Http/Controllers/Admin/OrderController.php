<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Notifications\OrderDelivery;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orderCount = Order::whereHas('orderItems')->count();
        $dataPerPage = 2;
        $orderPages = ceil($orderCount / $dataPerPage);  // ceil()無條件進位
        $currentPage = isset($request->all()['page']) ? $request->all()['page'] : 1;  // 前端如果有帶page參數就顯示那頁沒有就1
        $orders = Order::with(['user', 'orderItems.product'])->orderBy('created_at', 'desc')  // 利用with遇載資料庫優化效能
            ->offset($dataPerPage * ($currentPage - 1))  // 資料從第幾筆開始顯示
            ->limit($dataPerPage)  // 一頁顯示資料限制
            ->whereHas('orderItems')  // 子查詢，有orderItems(購物清單)才顯示
            ->get();

        return view('admin.orders.index', [
            'orders' => $orders,
            'orderCount' => $orderCount,
            'orderPages' => $orderPages
        ]);
    }

    public function delivery($id)
    {
        $order = Order::find($id);
        if ($order->is_shipped) {
            return response(['result' => false]);
        } else {
            $order->update(['is_shipped' => true]);
            $order->user->notify(new OrderDelivery);
            return response(['result' => true]);
        }
    }
}
