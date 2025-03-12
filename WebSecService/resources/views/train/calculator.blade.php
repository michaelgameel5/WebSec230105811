@extends('layouts.master')
@section('title', 'welcome')
@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4 border-0 rounded-4">
        <h2 class="text-center text-primary mb-4">Simple Calculator</h2>

        <div class="mb-3">
            <label for="num1" class="form-label">Enter first number:</label>
            <input type="number" id="num1" class="form-control" placeholder="First number">
        </div>

        <div class="mb-3">
            <label for="num2" class="form-label">Enter second number:</label>
            <input type="number" id="num2" class="form-control" placeholder="Second number">
        </div>

        <div class="text-center mb-3">
            <button class="btn btn-primary mx-1" onclick="calculate('+')">+</button>
            <button class="btn btn-secondary mx-1" onclick="calculate('-')">-</button>
            <button class="btn btn-success mx-1" onclick="calculate('*')">×</button>
            <button class="btn btn-danger mx-1" onclick="calculate('/')">÷</button>
        </div>

        <h4 class="text-center mt-3">Result: <span id="result" class="text-success"></span></h4>
    </div>
</div>

<script>
    function calculate(operation) {
        let num1 = parseFloat(document.getElementById('num1').value);
        let num2 = parseFloat(document.getElementById('num2').value);
        let result;

        if (isNaN(num1) || isNaN(num2)) {
            result = "Please enter valid numbers";
        } else {
            switch (operation) {
                case '+': result = num1 + num2; break;
                case '-': result = num1 - num2; break;
                case '*': result = num1 * num2; break;
                case '/': 
                    result = num2 !== 0 ? (num1 / num2).toFixed(2) : "Cannot divide by zero";
                    break;
                default: result = "Invalid operation";
            }
        }
        
        document.getElementById('result').textContent = result;
    }
</script>
@endsection