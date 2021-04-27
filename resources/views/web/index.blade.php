<div>
    <a href="/">商品列表</a>
    <a href="/contact-us">聯絡我們</a>
</div>
<h2>商品列表</h2>
<table>
    <thead>
        <tr>
            <td>標題</td>
            <td>內容</td>
            <td>價格</td>
            <td></td>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->title }}</td>
            <td>{{ $product->content }}</td>
            <td>{{ $product->price }}</td>
            <td></td>
        </tr>
        @endforeach
    </tbody>
</table>