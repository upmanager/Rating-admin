<?php

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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('login'));
});

Auth::routes(['verify' => false, 'reset' => false]);

Route::middleware(['auth', 'StatusCheck'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect(route('dashboard.index'));
    });
    
    Route::resource('dashboard', DashboardController::class);

    Route::middleware(['roleChecker:admin'])->resource('roles', RolesController::class);
    Route::middleware(['roleChecker:admin'])->resource('questions', QuestionsController::class);
    Route::middleware(['roleChecker:admin,client'])->resource('facilities', FacilitiesController::class);
    Route::middleware(['roleChecker:admin,client,worker'])->resource('ratings', RatingController::class);
    Route::middleware(['roleChecker:admin,client,worker'])->resource('notifications', NotificationsController::class);
});
