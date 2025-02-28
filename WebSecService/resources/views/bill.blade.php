@extends('layouts.master')
@section('title', 'Welcome')
@section('content')
    <div class="card col-sm-20">
        <div class="card-header">{{ $bill->supermarket }} #{{ $bill->pos }}</div>
    </div>

    <table class="table table-striped">
        <tr>
            <th>Quantity</th>
            <th>Name</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
        @foreach ($bill->products as $product)
        <tr>
            <td>{{ $product->quantatiy }} {{ $product->unit }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->price * $product->quantatiy }}</td>
        </tr>
        @endforeach
    </table>
@endsection
