<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\checkRole;
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

Route::get('/', function () {
    return view('welcome');
})->name('home');

//auth routing
Route::post('/login/post','auth\UserController@login');


//admin dashboard routing
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('dashboard','DashboardController@adminDashboard');
    Route::get('getSchools','SuperAdminController@getSchool');
    Route::get('author','SuperAdminController@author');
    Route::get('getAuthority','SuperAdminController@getAuthority');
});

//principal dashboard routing
Route::middleware(['auth', 'principal'])->prefix('principal')->group(function () {
    Route::get('dashboard','DashboardController@principalDashboard');
});

//principal dashboard routing
Route::middleware(['auth', 'student'])->prefix('student')->group(function () {
    Route::get('dashboard','DashboardController@studentDashboard');
});

//principal dashboard routing
Route::middleware(['auth', 'stuff'])->prefix('stuff')->group(function () {
    Route::get('dashboard','DashboardController@stuffDashboard');
});



Auth::routes();
