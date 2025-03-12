@extends('layouts.master')
@section('title', 'welcome')
@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4 border-0 rounded-4">
        <h2 class="text-center text-primary mb-4">GPA Simulator</h2>

        {{-- Course Selection --}}
        <div class="mb-3">
            <label for="courseSelect" class="form-label">Select Course:</label>
            <select id="courseSelect" class="form-select">
                <option value="">-- Choose a Course --</option>
                @foreach ($courses as $course)
                    <option value="{{ $course['code'] }}" 
                            data-title="{{ $course['title'] }}" 
                            data-credits="{{ $course['credits'] }}">
                        {{ $course['code'] }} - {{ $course['title'] }} ({{ $course['credits'] }} Credits)
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Grade Input --}}
        <div class="mb-3">
            <label for="grade" class="form-label">Enter Grade (A-F):</label>
            <input type="text" id="grade" class="form-control" placeholder="Example: A+, B, C-" maxlength="2">
        </div>

        {{-- Add Course Button --}}
        <div class="text-center mb-3">
            <button class="btn btn-success" onclick="addCourse()">Add Course</button>
        </div>

        {{-- Table for Courses --}}
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Course Code</th>
                    <th>Title</th>
                    <th>Credit Hours</th>
                    <th>Grade</th>
                    <th>Points</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="courseList"></tbody>
        </table>

        {{-- GPA Calculation --}}
        <h4 class="text-center mt-3">GPA: <span id="gpa" class="text-success">0.00</span></h4>
    </div>
</div>

<script>
    let courses = [];
    
    function addCourse() {
        let select = document.getElementById("courseSelect");
        let gradeInput = document.getElementById("grade");
        let grade = gradeInput.value.toUpperCase();
        let selectedOption = select.options[select.selectedIndex];

        if (!selectedOption.value || grade === "") {
            alert("Please select a course and enter a grade.");
            return;
        }

        let courseCode = selectedOption.value;
        let title = selectedOption.getAttribute("data-title");
        let credits = parseInt(selectedOption.getAttribute("data-credits"));

        let gradePoints = getGradePoints(grade);
        if (gradePoints === null) {
            alert("Invalid grade! Please enter a valid grade (A, B+, C-, etc.).");
            return;
        }

        courses.push({ code: courseCode, title, credits, grade, gradePoints });

        updateTable();
        calculateGPA();
    }

    function getGradePoints(grade) {
        let scale = {
            'A+': 4.3, 'A': 4.0, 'A-': 3.7, 'B+': 3.3, 'B': 3.0, 'B-': 2.7,
            'C+': 2.3, 'C': 2.0, 'C-': 1.7, 'D+': 1.3, 'D': 1.0, 'F': 0.0
        };
        return scale[grade] !== undefined ? scale[grade] : null;
    }

    function updateTable() {
        let tbody = document.getElementById("courseList");
        tbody.innerHTML = "";
        courses.forEach((course, index) => {
            let row = `<tr>
                <td>${course.code}</td>
                <td>${course.title}</td>
                <td>${course.credits}</td>
                <td>${course.grade}</td>
                <td>${course.gradePoints.toFixed(2)}</td>
                <td><button class="btn btn-danger btn-sm" onclick="removeCourse(${index})">Remove</button></td>
            </tr>`;
            tbody.innerHTML += row;
        });
    }

    function removeCourse(index) {
        courses.splice(index, 1);
        updateTable();
        calculateGPA();
    }

    function calculateGPA() {
        let totalCredits = 0, totalPoints = 0;

        courses.forEach(course => {
            totalCredits += course.credits;
            totalPoints += course.gradePoints * course.credits;
        });

        let gpa = totalCredits > 0 ? (totalPoints / totalCredits).toFixed(2) : "0.00";
        document.getElementById("gpa").textContent = gpa;
    }
</script>
@endsection