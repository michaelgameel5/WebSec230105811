@extends('layouts.master')
@section('title', 'welcome')
@section('content')
    @php ($j=5)
    <h1>Michael Gameel</h1>
        <div class="card m-4">
            <div class="card-header">Even Numbers</div>
            <div class="card-body">
                @foreach (range(1,100) as $i)
                    @if ($i%2==0)
                        <span class="badge bg-primary">{{$i}}</span>
                    @else
                        <span class="badge bg-secondary">{{$i}}</span>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</body>
@endsection