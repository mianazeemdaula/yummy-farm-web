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

Route::get('data', function(){

    $users = \App\Models\User::find(3);
    // return Lession::join('lession_logs','lession_logs.lession_id', '=', 'lessions.id')
    // ->join('users','lessions.student_id', '=', 'users.id')
    // ->groupBy('lessions.id','users.name')
    // ->where('lessions.tutor_id', 3)
    // ->get(['lessions.id','users.name',\DB::raw('SUM(TIMESTAMPDIFF(MINUTE,start_time,end_time) / 60) as value')]);
    // $lession = Notifications::find(1);
    // return Fcm::sendNotification($lession);
    // return Lession::whereDate('start_date','>=', Carbon::now())->whereDate('end_date', '>=', Carbon::now())->get()->pluck('id');
    // return $users->instrumentFavorite;
    // return view('welcome') ;

    return $users->activeStudents;
});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');


    Route::resource('user','UserController');
    // Route::get('export','UserController@export');
    Route::resource('instrument','InstrumentController');
    Route::resource('category','InstrumentCategoryController');
    Route::resource('ingredientunit','IngredientUnitController');
    Route::resource('ingredientcategory','IngredientCategoryController');

    Route::middleware(['role:super-admin'])->group(function () {
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
