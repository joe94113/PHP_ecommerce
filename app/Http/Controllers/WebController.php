<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;

class WebController extends Controller
{
    public $controller = [];
    public function __construct()
    {
        $user = User::find(3);
        $this->notifications = $user->notifications ?? [];  // 假設$user->notifications不存在則為[]
    }

    public function index()
    {
        $products = Product::all();

        return view('web.index', ['products' => $products, 'notifications' => $this->notifications]);
    }

    public function contactUs()
    {
        return view('web.contact_us', ['notifications' => $this->notifications]);
    }

    public function readNotification(Request $request)
    {
        $id = $request->all()['id'];
        DatabaseNotification::find($id)->markAsRead();

        return response(['result' => true]);
    }
}
