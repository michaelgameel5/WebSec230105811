@extends('layouts.master')
@section('title', 'Verification Email')
@section('content')

    <p>Dear {{$name}},</p>
    <p>Clik on the following link to verify your account:</p>
    <p><a href="{{$link}}" target='_blank'>Verification Link</a></p>
 
@endsection
