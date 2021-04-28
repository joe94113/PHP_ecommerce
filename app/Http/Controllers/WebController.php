<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class WebController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $user = User::find(3);
        $notifications = $user->notifications ?? [];  // 假設$user->notifications不存在則為[]
        return view('web.index', ['products' => $products, 'notifications' => $notifications]);
    }

    public function contactUs()
    {
        return view('web.contact_us');
    }
}
