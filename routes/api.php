<?php

use App\Helpers\Fcm;
use App\Models\Notifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user-t', function (Request $request) {
    return $request->user();
});

Route::get('notif/{id}', function ($id) {

return Fcm::sendNotification(Notifications::find($id));
});
Route::post('auth/login', 'Api\AuthController@login');
Route::post('auth/register', 'Api\AuthController@register');
Route::post('auth/reset-password', 'Api\AuthController@sendPasswordResetEmail');

// Social Login
Route::post('auth/sociallogin', 'Api\AuthController@sociallogin');
Route::post('auth/facebook/callback', 'Api\AuthController@socialcallback');
Route::post('auth/google/callback', 'Api\AuthController@socialcallback');



Route::middleware('auth:sanctum')->group(function(){

    // User
    Route::post('auth/update-image', 'Api\AuthController@updateAvatar');
    Route::post('auth/update-profile', 'Api\AuthController@updateProfile');
    Route::post('auth/update-tutor', 'Api\AuthController@saveAsTutor');
    Route::resource('user', 'Api\UserController');
    Route::resource('tutor', 'Api\TutorController');
    Route::get('workinghours', 'Api\UserController@teachingHours');
    // Tutor Time
    Route::resource('tutorTime', 'Api\TutorTimeController');

    // Instruments
    Route::resource('instrument', 'Api\InstrumentController');
    Route::get('instrument-latest', 'Api\InstrumentController@getLatest');

    // Lessions
    Route::resource('lession', 'Api\LessionController');
    Route::post('lession-add-note', 'Api\LessionController@addNote');
    Route::post('lession/add-music-sheet', 'Api\LessionController@addMusicSheet');
    Route::post('lession/add-video', 'Api\LessionController@addVideo');
    Route::post('lession-send-review', 'Api\LessionController@submitReview');
    Route::post('lession-update-sheets', 'Api\LessionController@updateMusicSheets');

    // Reporting Tutors
    Route::resource('report-tutor', 'Api\ReportUserController');

    // Favourite
    Route::resource('favourite', 'Api\FavouriteController');

    // Tutor Videos
    Route::resource('videos', 'Api\VideoController');

    // Libaries
    Route::resource('library', 'Api\LibraryController');

    // Inbox
    Route::resource('inbox', 'Api\InboxController');

    // Notifications
    Route::resource('notificaiton', 'Api\NotificationController');
    Route::post('notificaiton-del-all', 'Api\NotificationController@deleteAll');

    // Search Tutors and Instruments by Name
    Route::post('search-by-name', 'Api\SearchController@searchByName');
});
