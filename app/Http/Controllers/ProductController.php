<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // 資料庫模組
use Illuminate\Support\Facades\Redis;  // 引入redis
use App\Models\Product;
use App\Http\Services\ShortUrlService;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $data = $this->getData();
        // $data = DB::table('products')->get();
        // https://laravel.com/docs/8.x/redis#introduction
        $data = json_decode(Redis::get('products'));  // 可優化效能redis
        return response($data);
    }

    public function checkProduct(Request $request)
    {
        $id = $request->all()['id'];
        $product = Product::find($id);
        if ($product->quantity > 0) {
            return response(true);
        } else {
            return response(false);
        }
    }

    public function  sharedUrl($id)
    {
        $service = new ShortUrlService();
        $url = $service->makeShortUrl("http://localhost:8000/products/$id");
        return response(['url' => $url]);
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
        $data = $this->getData();
        $newdata = $request->all();
        $data->push(collect($newdata));
        dump($data);
        return response()->json($data);
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
        $form = $request->all();
        $data = $this->getData();
        $selectedData = $data->where('id', $id)->first();
        $selectedData = $selectedData->merge(collect($form));

        return response()->json($selectedData);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->getData();
        $data = $data->filter(function ($product) use ($id) {
            return $product['id'] != $id;
        });
        return response()->json($data->values());
    }

    public function getData()
    {
        return collect([
            collect([
                'id' => 0,
                'title' => '測試商品一',
                'content' => '這是很棒的商品',
                'price' => 50
            ]),
            collect([
                'id' => 1,
                'title' => '測試商品-二',
                'content' => '這是很棒的商品',
                'price' => 30
            ]),
        ]);
    }
}
