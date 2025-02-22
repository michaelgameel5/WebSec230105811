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
Route::get('/test', function () {
    return view('test'); //prime.blade.php
   });