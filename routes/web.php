<?php

use Illuminate\Support\Facades\Route;
use App\Models\ComponentCategory;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/ciao', function () {
    $user = auth()->user();
    $machine = \App\Models\Machine::find(1);
    return view('welcome' ,[
        'user' => $user,
        'machine' => $machine
    ]);
});
