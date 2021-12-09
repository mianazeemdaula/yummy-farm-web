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
    $order = App\Models\Order::with(['details'])->where('id',$id)->first();
    return  response()->json($order, 200,[],JSON_PRETTY_PRINT);;
    return Mail::to('mazeemrehan@gmail.com')->send(new \App\Mail\OrderGenerated($order));
    return App\Models\Order::with(['seller', 'customer', 'details.product'])->find($id);
});

Route::middleware(['auth','role:admin,super-admin'])->group(function () {

    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('user','UserController');
    Route::resource('seller','SellerController');
    Route::resource('category','CategoryController');
    Route::resource('sub.category','SubCategoryController');
    Route::resource('order','OrderController');
    Route::resource('payment','PaymentController');
    Route::resource('chat','ChatController');

    Route::get('admin/password','UserController@getPassword');
    Route::post('admin/password','UserController@postPassword');
    
    Route::get('export/sellers','ExportController@sellers');
    Route::get('export/users','ExportController@users');
    Route::get('export/orders','ExportController@orders');
    Route::get('export/payments','ExportController@payments');
});


Auth::routes();

