<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<nav class="navbar navbar-expand-sm bg-light">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="./">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./even">Even</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./prime">Prime</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./multable">Multiplication</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./bill">Bill</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./trans">Transcript</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./items">Items</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./products">Products</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            @auth
                <li class="nav-item"><a class="nav-link">{{auth()->user()->name}}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('do_logout')}}">Logout</a></li>
            @else
                <li class="nav-item"><a class="nav-link" href="{{route('login')}}">Login</a></li>
            @endauth
        </ul>
    </div>
</nav>
</body>
</html>

