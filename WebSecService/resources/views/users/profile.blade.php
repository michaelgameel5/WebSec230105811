@extends('layouts.master')
@section('title', 'User Profile')
@section('content')
<div class="d-flex justify-content-center">
    <div class="m-4 col-sm-6">
        <table class="table table-striped">
            <tr>
                <th>Name</th><td>{{$user->name}}</td>
            </tr>
            <tr>
                <th>Email</th><td>{{$user->email}}</td>
            </tr>
            <tr>
                <th>Credit</th><td>{{$user->credit ?? 'N/A'}}</td>
            </tr>
            <tr>
                <th>Roles</th>
                <td>
                    @foreach($user->roles as $role)
                        <span class="badge bg-primary">{{$role->name}}</span>
                    @endforeach
                </td>
            </tr>
            <tr>
                <th>Direct Permissions</th>
                <td>
                    @if($permissions->isEmpty())
                        <span class="text-muted">No direct permissions</span>
                    @endif
                    @foreach($permissions as $permission)
                        <span class="badge bg-success">{{$permission->name}}</span>
                    @endforeach
                </td>
            </tr>
            <tr>
            <tr>
            <th>Purchased Products</th>
            <td>
                @if($purchasedProducts->isEmpty())
                    <span class="text-muted">No products purchased yet</span>
                @else
                    <ul class="list-group">
                        @foreach($purchasedProducts as $product)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $product->name }} - ${{ $product->price }}
                                <span class="badge bg-secondary">Qty: {{ $product->pivot->quantity }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </td>
        </tr>

        </table>
        <div class="row">
            <div class="col col-10"></div>
            <div class="col col-2">
                @if(auth()->user()->hasPermissionTo('edit_users') || auth()->id() == $user->id)
                    <a href="{{route('users_edit')}}" class="btn btn-success form-control">Edit</a>
                @endif
            </div>
        </div>
@endsection
