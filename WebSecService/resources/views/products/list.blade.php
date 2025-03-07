@extends('layouts.master')
@section('title', 'Prime Numbers')
@section('content')
@foreach($products as $product)
    <form>
        <div class="row">
            <div class="col col-sm-2">
                <input name="keywords" type="text" class="form-control" placeholder="Search Keywords" value="{{ request()->keywords }}" />
            </div>
            <div class="col col-sm-2">
                <input name="min_price" type="numeric" class="form-control" placeholder="Min Price" value="{{ request()->min_price }}"/>
            </div>
            <div class="col col-sm-2">
                <input name="max_price" type="numeric" class="form-control" placeholder="Max Price" value="{{ request()->max_price }}"/>
            </div>
            <div class="col col-sm-2">
                <select name="order_by" class="form-select">
                    <option value="" {{ request()->order_by==""?"selected":"" }} disabled>Order By</option>
                    <option value="name" {{ request()->order_by=="name"?"selected":"" }}>Name</option>
                    <option value="price" {{ request()->order_by=="price"?"selected":"" }}>Price</option>
                </select>
            </div>
            <div class="col col-sm-2">
                <select name="order_direction" class="form-select">
                    <option value="" {{ request()->order_direction==""?"selected":"" }} disabled>Order Direction</option>
                    <option value="ASC" {{ request()->order_direction=="ASC"?"selected":"" }}>ASC</option>
                    <option value="DESC" {{ request()->order_direction=="DESC"?"selected":"" }}>DESC</option>
                </select>
            </div>
            <div class="col col-sm-1">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <div class="col col-sm-1">
                <button type="reset" class="btn btn-danger">Reset</button>
            </div>
        </div>
    </form>
    <div class="card mt-2">
        <div class="card-body">
            <div class="row">
                <div class="col col-sm-12 col-lg-4">
                    <!-- <img src="{{asset("images/$product->photo")}}" -->
                    <img src="{{ asset($product->photo) }}"
                    class="img-thumbnail" alt="{{$product->name}}">
                </div>
                <div class="col col-sm-12 col-lg-8 mt-3">
                    <h3>{{$product->name}}</h3>
                    <table class="table table-striped">
                        <tr><th width="20%">Name</th><td>{{$product->name}}</td></tr>
                        <tr><th>Model</th><td>{{$product->model}}</td></tr>
                        <tr><th>Code</th><td>{{$product->code}}</td></tr>
                        <tr><th>Description</th><td>{{$product->description}}</td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endforeach 
@endsection
