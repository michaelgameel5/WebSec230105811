<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Michael</title>
    <link href="public/css/bootstrap.min.css" rel="stylesheet">
    <script src="public/js/bootstrap.bundle.min.js"></script>  
</head>
<body>
    <?php
    function isPrime($number){
        if ($number<=1) return false;
        $i = $number - 1;
        while ($i > 1){
            if ($number % $i ==0) return false;
            $i--;
            }
        return true;
    }
    ?>
    @php ($j=5)
    <h1>Michael Gameel</h1>
    <div class="card m-4 col-sm-2">
        <div class="card-header">Multiplication Table 5</div>
        <div class="card-body">
            <table>
                @foreach (range(1,10) as $i)
                <tr><td>{{$i}} * {{$j}} = </td><td>{{$i * $j}}</td></tr>
                @endforeach
            </table>
        </div>
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
</body>
</html>