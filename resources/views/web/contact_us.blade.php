<!--繼承layouts.app模板-->
@extends('layouts.app')
<!--會去找layouts.app對應@yield('content')-->
@section('content')
<h3>聯絡我們</h3>
<form action="">
    請問你是:<input type="text"><br>
    請問你的消費時間:<input type="date"><br>
    你消費的商品種類:
    <select name="" id="">
        <option value="物品"></option>
        <option value="食物"></option>
    </select><br>
    <button>送出</button>
</form>
@endsection