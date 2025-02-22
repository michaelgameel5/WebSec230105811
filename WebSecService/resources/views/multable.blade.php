@extends('layouts.master')
@section('title', 'welcome')
@section('content')
    <div class="card m-4 col-sm-5">
        <div class="card-header">Multiplication Table 5 + {{$msg}}</div>
        <div class="card-body">
            <table>
                @foreach (range(1,10) as $i)
                <tr><td>{{$i}} * {{$j}} = </td><td>{{$i * $j}}</td></tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection