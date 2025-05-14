<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\UsersController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Web\ExamController;
use App\Mail\VerificationEmail;
use App\Http\Controllers\Auth\AuthController;


// Auth::routes(['verify' => true]);

// Example of a route protected by email verification:
// Route::get('/', function () {
//     return view('train.welcome');
// })->middleware(['auth', 'verified'])->name('home');

Route::get('/', function () {
    return view('train.welcome');
})->name('home');

// Route::get('/multable/{number?}', function ($number = null) {
//     $j = $number??1;
//     return view('multable', compact('j')); //multable.blade.php
//    });
Route::get('/multable', function (Request $request) {
    $j = $request->number;
    $msg = $request->msg;
    return view('train.multable', compact('j', 'msg')); //multable.blade.php
   })->name('multable');
Route::get('/even', function () {
    return view('train.even'); //even.blade.php
   })->name('even');
Route::get('/prime', function () {
    return view('train.prime'); //prime.blade.php
   })->name('prime');
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
})->name('bill');
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
})->name('trans');
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
})->name('items');
Route::get('/calculator', function () {
    return view('train.calculator');
})->name('calculator');
Route::get('/gpacalc', function () {
    $courses = [
        ['code' => 'CS101', 'title' => 'Introduction to Programming', 'credits' => 3],
        ['code' => 'CS102', 'title' => 'Data Structures', 'credits' => 4],
        ['code' => 'CS103', 'title' => 'Database Systems', 'credits' => 3],
        ['code' => 'CS104', 'title' => 'Operating Systems', 'credits' => 3],
        ['code' => 'CS105', 'title' => 'Computer Networks', 'credits' => 3]
    ];
    return view('train.gpacalc', compact('courses'));
})->name('gpacalc');



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
Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UsersController::class, 'index'])->name('users_index');
    Route::get('/users/create', [UsersController::class, 'create'])->name('users_create');
    Route::post('/users', [UsersController::class, 'store'])->name('users_store');
    Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users_destroy');
    Route::put('/users/{user}', [UsersController::class, 'update'])->name('users_update');
});
Route::get('profile/{user?}', [UsersController::class, 'profile'])->name('profile');
Route::get('/users/edit/{user?}', [UsersController::class, 'edit'])->name('users_edit');
Route::put('users/save/{user}', [UsersController::class, 'save'])->name('users_save');






Route::middleware(['auth'])->group(function () {
    Route::get('/change-password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/change-password', [ChangePasswordController::class, 'updatePassword'])->name('password.update');
});

Route::get('/questions', [ExamController::class, 'list'])->name('questions.list');
Route::get('/questions/create', [ExamController::class, 'create'])->name('questions.create');
Route::post('/questions', [ExamController::class, 'store'])->name('questions.store');
Route::get('/questions/{question}/edit', [ExamController::class, 'edit'])->name('questions.edit');
Route::put('/questions/{question}', [ExamController::class, 'update'])->name('questions.update');
Route::delete('/questions/{question}', [ExamController::class, 'destroy'])->name('questions.destroy');
Route::get('/questions/start', [ExamController::class, 'start'])->name('questions.start');
Route::post('/questions/submit', [ExamController::class, 'submit'])->name('questions.submit');
Route::get('/questions/result', [ExamController::class, 'result'])->name('questions.result');


use App\Http\Controllers\Web\BooksController;

Route::get('/books', [BooksController::class, 'index'])->name('books.index');
Route::get('/books/create', [BooksController::class, 'create'])->name('books.create');
Route::post('/books', [BooksController::class, 'store'])->name('books.store');

use App\Http\Controllers\Web\TasksController;
 Route::get('/tasks', [TasksController::class, 'index'])->name('tasks_index')->middleware('auth'); 
 Route::get('/tasks/create', [TasksController::class, 'create'])->name('tasks_create'); 
 Route::post('/tasks', [TasksController::class, 'store'])->name('tasks_store'); 
 Route::get('/tasks/{task}/edit', [TasksController::class, 'edit'])->name('tasks_edit'); 
 Route::put('/tasks/{task}', [TasksController::class, 'update'])->name('tasks_update'); 
 Route::delete('/tasks/{task}', [TasksController::class, 'destroy'])->name('tasks_destroy');

 Route::get('verify', [UsersController::class, 'verify'])->name('verify');

Route::get('/test-email', function () {
    try {
        Mail::raw('This is a test email.', function ($message) {
            $message->to('test@example.com')->subject('Test Email');
        });
        return 'Test email sent successfully!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});


Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot_password');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('send_reset_link');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('do_reset_password');

Route::get('/auth/google', [UsersController::class, 'redirectToGoogle'])->name('login_with_google');
Route::get('/auth/google/callback', [UsersController::class, 'handleGoogleCallback']);


Route::get('/cryptography', function (Request $request) {
    $data = $request->data ?? "Welcome to Cryptography";
    $action = $request->action ?? "Encrypt";
    $result = $request->result ?? "";
    $status = "Failed";

    $key = substr('thisisasecretkey', 0, 16); // Ensure the key is 16 bytes
    $cipher = 'aes-128-ecb';

    if ($action == "Encrypt") {
        $temp = openssl_encrypt($data, $cipher, $key, OPENSSL_RAW_DATA);

        if ($temp) {
            $status = 'Encrypted Successfully';
            $result = base64_encode($temp);
        }

    } elseif ($action == "Decrypt") {
        $temp = base64_decode($data); // Decode the base64-encoded string
        $result = openssl_decrypt($temp, $cipher, $key, OPENSSL_RAW_DATA);

        if ($result) {
            $status = 'Decrypted Successfully';
        } else {
            $status = 'Decryption Failed';
        }

    } else if($request->action=="Hash") {
        $temp = hash('sha256', $request->data);
        $result = base64_encode($temp);
        $status = 'Hashed Successfully';

    } else if($request->action=="Sign") {
        $path = storage_path('app/private/useremail@domain.com.pfx');
        $password = '12345678';
        $certificates = [];
        $pfx = file_get_contents($path);
        openssl_pkcs12_read($pfx, $certificates, $password);
        $privateKey = $certificates['pkey'];
        $signature = '';
        if(openssl_sign($request->data, $signature, $privateKey, 'sha256')) {
            $result = base64_encode($signature);
            $status = 'Signed Successfully';
        }
    }
       
    

    return view('train.cryptography', compact('data', 'result', 'action', 'status'));
})->name('cryptography');



