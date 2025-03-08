@extends('layouts.master')

@section('title', 'Items')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Item Catalog</h2>
    
    <div class="row">
        @foreach ($items as $item)
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <img src="{{ $item->image }}" class="card-img-top" alt="{{ $item->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $item->name }}</h5>
                    <p class="card-text">{{ $item->description }}</p>
                    <h6 class="card-text"><strong>${{ number_format($item->price, 2) }}</strong></h6>
                    <a href="#" class="btn btn-primary">Add to Cart</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
