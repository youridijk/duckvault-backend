<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DiaryEntryController;
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
   return \App\Models\UserList::with(['issues', 'characters', 'publications', 'stories'])->find($id);
});

Route::group([
    'prefix' => 'lists',
    'where' => [
        'issue_code' => '(.*)',
        'publication_code' => '(.*)',
        'story_code' => '(.*)',
        'character_code' => '(.*)',
    ]
], function () {
    Route::get('{list}/issues', [UserListIssueController::class, 'getAll']);
    Route::post('{list}/issues/{issue_code}', [UserListIssueController::class, 'add']);
    Route::delete('{list}/issues/{issue_code}', [UserListIssueController::class, 'delete']);

    Route::get('{list}/publications', [UserListPublicationController::class, 'getAll']);
    Route::post('{list}/publications/{publication_code}', [UserListPublicationController::class, 'add']);
    Route::delete('{list}/publications/{publication_code}', [UserListPublicationController::class, 'delete']);

    Route::get('{list}/stories', [UserListStoryController::class, 'getAll']);
    Route::post('{list}/stories/{story_code}', [UserListStoryController::class, 'add']);
    Route::delete('{list}/stories/{story_code}', [UserListStoryController::class, 'delete']);

    Route::get('{list}/characters', [UserListCharacterController::class, 'getAll']);
    Route::post('{list}/characters/{character_code}', [UserListCharacterController::class, 'add']);
    Route::delete('{list}/characters/{character_code}', [UserListCharacterController::class, 'delete']);
});

Route::resource('diary_entries', DiaryEntryController::class);
