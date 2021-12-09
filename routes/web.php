<?php

use App\Helpers\Fcm;
use App\Models\Lession;
use App\Models\Notifications;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['register' => false, 'verify' => true]);

Route::get('data/{id}', function($id){
    $order = App\Models\Order::find($id);
    return Mail::to('mazeemrehan@gmail.com')->send(new \App\Mail\OrderGenerated($order));
    return App\Models\Order::with(['seller', 'customer', 'details.product'])->find($id);
});

Route::middleware(['auth','role:admin,super-admin'])->group(function () {

    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('user','UserController');
    Route::resource('category','CategoryController');
    Route::resource('sub.category','SubCategoryController');

    Route::prefix('admin')->group(function () {
        //Route::resource('role','RoleController');
        // Route::resource('permission','PermissionController');
    // Route::resource('user','UserController');
        //Route::resource('expense','ExpenseController');
    });

    Route::get('admin/password','UserController@getPassword');
    Route::post('admin/password','UserController@postPassword');
    
});


Auth::routes();

