<?php

use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\Diary\DiaryEntryController;
use App\Http\Controllers\Diary\DiaryEntryIssueController;
use App\Http\Controllers\Diary\DiaryEntryStoryVersionController;
use App\Http\Controllers\OwnedIssuesController;
use App\Http\Controllers\SanctumAuthController;
use App\Http\Controllers\UserController;
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

Route::controller(JWTAuthController::class)
    ->prefix('auth/jwt')
    ->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
        Route::post('user', 'user');
    });

Route::controller(SanctumAuthController::class)
    ->prefix('auth/sanctum')
    ->group(function () {
       Route::post('login', 'login');
       Route::post('user', 'user');
       Route::post('tokens', 'tokens');
       Route::post('logout', 'logout');
    });

Route::resource('lists', UserListController::class)->except(['edit', 'create']);
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

Route::group([
    'prefix' => 'diary_entries'
], function () {
    Route::post('story_versions', [DiaryEntryStoryVersionController::class, 'store_v2']);
    Route::post('issues', [DiaryEntryIssueController::class, 'store_v2']);
});

Route::resource('diary_entries', DiaryEntryController::class)
//    ->except('store')
    ->except(['edit', 'create']);

Route::controller(OwnedIssuesController::class)
    ->prefix('user/owned_issues')
    ->where([
        'issue_code' => '(.*)',
    ])
    ->group(function () {
        Route::get('', 'index');
        Route::get('/has/{issue_code}', 'owns_issue');
        Route::get('{issue_code}', 'show');
        Route::post('{issue_code}', 'store');
        Route::delete('{issue_code}', 'destroy');
    });

Route::get('user/{user_id}/owned_issues', [OwnedIssuesController::class, 'show_of_user']);
Route::get('user/{user_id}', [UserController::class, 'show_user']);
