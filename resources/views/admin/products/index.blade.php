<!--繼承layouts.app模板-->
@extends('layouts.admin_app')
<!--會去找layouts.app對應@yield('content')-->
@section('content')

<h2>產品列表</h2>
<span>產品總數: {{ $productCount }}</span>
<div>
    <input type="button" class="import" value="匯入Excel">
</div>
<!-- 後端執行withErrors，前端會包成$errors，只使用一次的變數 -->
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<table>
    <thead>
        <tr>
            <td>編號</td>
            <td>標題</td>
            <td>內容</td>
            <td>價格</td>
            <td>數量</td>
            <td>圖片</td>
            <td>功能</td>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->title }}</td>
            <td>{{ $product->content }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->quantity }}</td>
            <td><a href="{{ $product->image_url }}">圖片連結</a></td>
            <td>
                <input type="button" class="upload_image" value="上傳圖片" data-id={{$product->id}}>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div>
    @for ($i=0; $i <= $productPages; $i++) <a href="/admin/products?page={{ $i }}">第 {{ $i }} 頁</a>
        @endfor
</div>
<script>
    $('.upload_image').click(function() {
        $('#product_id').val($(this).data('id'))
        $('#upload_image').modal()
    })

    $('.import').click(function() { // 呼叫護出Excel modal
        $('#import').modal()
    })
</script>
@endsection