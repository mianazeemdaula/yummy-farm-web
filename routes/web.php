<?php

use App\Helpers\Fcm;
use App\Models\Lession;
use App\Models\Notifications;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['register' => false, 'verify' => true]);

Route::get('data/{id}', function($id){

    $product = \App\Models\Product::find($id);
    $cat = $product->categories;
    $meat = $product->meat;
    return $product;
});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');


    Route::resource('user','UserController');
    // Route::get('export','UserController@export');
    Route::resource('instrument','InstrumentController');
    Route::resource('category','InstrumentCategoryController');
    Route::resource('ingredientunit','IngredientUnitController');
    Route::resource('ingredientcategory','IngredientCategoryController');

    Route::middleware(['role:admin'])->group(function () {
        Route::prefix('admin')->group(function () {
            //Route::resource('role','RoleController');
            // Route::resource('permission','PermissionController');
           // Route::resource('user','UserController');
            //Route::resource('expense','ExpenseController');
        });
    });

    // Route::resource('recipe','RecipeController');

    Route::get('admin/password','UserController@getPassword');
    Route::post('admin/password','UserController@postPassword');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
