 <?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\UsersController;
use App\Http\Controllers\Controller;

Route::get('/', function () {
    return view('train.welcome');
});

// Route::get('/multable/{number?}', function ($number = null) {
//     $j = $number??1;
//     return view('multable', compact('j')); //multable.blade.php
//    });
Route::get('/multable', function (Request $request) {
    $j = $request->number;
    $msg = $request->msg;
    return view('train.multable', compact('j', 'msg')); //multable.blade.php
   });
Route::get('/even', function () {
    return view('train.even'); //even.blade.php
   });
Route::get('/prime', function () {
    return view('train.prime'); //prime.blade.php
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

    return view('train.bill', compact("bill"));
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

    return view('train.trans', compact('courses'));
});
Route::get('/items', function () {
    $items = [
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

    return view('train.items', compact('items'));
});
Route::get('/products', [ProductsController::class, 
    'list'])->name('products_list');
Route::get('products/edit/{product?}', [ProductsController::class,
    'edit'])->name('products_edit');
Route::post('products/save/{product?}', [ProductsController::class,
    'save'])->name('products_save');
Route::get('products/delete/{product}', [ProductsController::class,
    'delete'])->name('products_delete');
Route::get('/products/search', [ProductsController::class,
    'search'])->name('products_search');



Route::get('register', [UsersController::class, 'register'])->name('register');
Route::post('register', [UsersController::class, 'doRegister'])->name('do_register');
Route::get('login', [UsersController::class, 'login'])->name('login');
Route::post('login', [UsersController::class, 'doLogin'])->name('do_login');
Route::get('logout', [UsersController::class, 'doLogout'])->name('do_logout');


