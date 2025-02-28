 <?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/multable/{number?}', function ($number = null) {
//     $j = $number??1;
//     return view('multable', compact('j')); //multable.blade.php
//    });
Route::get('/multable', function (Request $request) {
    $j = $request->number;
    $msg = $request->msg;
    return view('multable', compact('j', 'msg')); //multable.blade.php
   });
Route::get('/even', function () {
    return view('even'); //even.blade.php
   });
Route::get('/prime', function () {
    return view('prime'); //prime.blade.php
   });

Route::get('/bill', function () {
    $bill = (object)[];
    $bill->supermarket = "Carrefour";
    $bill->pos = "815";
    $bill->products = [
        (object)["quantatiy" => 5, "unit" => "Unit", "name" => "Twix", "price" => 230],
        (object)["quantatiy" => 2, "unit" => "Unit", "name" => "Mando", "price" => 40],
        (object)["quantatiy" => 4, "unit" => "Unit", "name" => "Twin", "price" => 260],
        (object)["quantatiy" => 6, "unit" => "Unit", "name" => "Hohh", "price" => 190]
    ];

    return view('bill', compact("bill"));
});


   Route::get('/trans', function () {
    $courses = [
        (object)["credit_hours" => 3, "course_code" => "CS101", "grade" => 85],
        (object)["credit_hours" => 4, "course_code" => "MATH102", "grade" => 73],
        (object)["credit_hours" => 2, "course_code" => "ENG103", "grade" => 90],
        (object)["credit_hours" => 3, "course_code" => "PHY104", "grade" => 65],
    ];

    function gpaletter($grade) {
        if ($grade >= 90) return "A+";
        elseif ($grade >= 85) return "A";
        elseif ($grade >= 85) return "A-";
        elseif ($grade >= 80) return "B+";
        elseif ($grade >= 75) return "B";
        elseif ($grade >= 70) return "B-";
        else return "F";
    }

    foreach ($courses as $course) {
        $course->gpa_letter = gpaletter($course->grade);
    }

    return view('trans', compact('courses'));
});



Route::get('/products', function () {
    $products = [
        (object)[
            'name' => 'Web Security Book',
            'image' => '/public/images/websecbook.png',
            'price' => 50,
            'description' => 'Web Security Book For Beginers.',
        ],
        (object)[
            'name' => 'Penetration Testing Kit',
            'image' => '/public/images/pentestkit.jpg',
            'price' => 200,
            'description' => 'Advanced Penetration Testing Kit.',
        ],
        (object)[
            'name' => 'Cybersecurity Course',
            'image' => '/public/images/cs_course.png',
            'price' => 300,
            'description' => 'Amazing Cybersecurity Course.',
        ]
    ];

    return view('products', compact('products'));
});

