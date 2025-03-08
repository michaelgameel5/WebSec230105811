@extends('layouts.master')
@section('title', 'welcome')
@section('content')
<table class="table table-striped">
    <tr>
        <th>Course Code</th>
        <th>Credit Hours</th>
        <th>Grade (100)</th>
        <th>GPA Letter</th>
    </tr>
    @foreach ($courses as $course)
    <tr>
        <td>{{ $course->course_code }}</td>
        <td>{{ $course->credit_hours }}</td>
        <td>{{ $course->grade }}</td>
        <td>{{ $course->gpa_letter }}</td>
    </tr>
    @endforeach
</table>


@endsection