@extends('layouts.master')
@section('title', 'welcome')
@section('content')
    @php ($j=5)
            <div class="card m-4">
                <div class="card-header">Prime Numbers</div>
                <div class="card-body">
                    @foreach (range(1,100) as $i)
                        @if (isPrime($i))
                            <span class="badge bg-primary">{{$i}}</span>
                        @else
                            <span class="badge bg-secondary">{{$i}}</span>
                        @endif
                    @endforeach
                </div>
            </div>

        </div>
    </div>
@endsection