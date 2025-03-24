@extends('layouts.master')

@section('content')
    <h1>Customers</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Credit</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->credit }}</td>
                    <td>
                        <form action="{{ route('customers.addCredit', $customer->id) }}" method="POST">
                            @csrf
                            <input type="number" name="credit" class="form-control" placeholder="Amount" required>
                            <button type="submit" class="btn btn-primary mt-2">Add Credit</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
