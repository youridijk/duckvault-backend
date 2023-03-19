<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserListController;
use App\Http\Controllers\UserListItems\UserListCharacterController;
use App\Http\Controllers\UserListItems\UserListIssueController;
use App\Http\Controllers\UserListItems\UserListPublicationController;
use App\Http\Controllers\UserListItems\UserListStoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('user', [AuthController::class, 'user']);
});

Route::resource('lists', UserListController::class);
Route::get('lists/{list}/all', function (string $id) {
   return \App\Models\UserList::with(['issues', 'characters', 'publications'])->find($id);
});

Route::group([
    'prefix' => 'lists',
    'where' => ['user_list_item' => '(.*)']
], function () {
    Route::post('{list}/issues/{user_list_item}', [UserListIssueController::class, 'add']);
    Route::delete('{list}/issues/{user_list_item}', [UserListIssueController::class, 'delete']);

    Route::post('{list}/publications/{user_list_item}', [UserListPublicationController::class, 'add']);
    Route::delete('{list}/publications/{user_list_item}', [UserListPublicationController::class, 'delete']);

    Route::post('{list}/stories/{user_list_item}', [UserListStoryController::class, 'add']);
    Route::delete('{list}/stories/{user_list_item}', [UserListStoryController::class, 'delete']);

    Route::post('{list}/characters/{user_list_item}', [UserListCharacterController::class, 'add']);
    Route::delete('{list}/characters/{user_list_item}', [UserListCharacterController::class, 'delete']);
});
