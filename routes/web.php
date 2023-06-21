<?php

use App\Http\Controllers\LoginController;
use App\Models\Diary\DiaryEntry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::group([
////    'middleware' => 'web',
//    'guard' => 'web'
//], function () {
//    Route::get('/', function () {
//        return view('welcome');
//    });
//
//    Route::get('login', [LoginController::class, 'getLoginPage']);
//    Route::post('login', [LoginController::class, 'login']);
//    Route::get('me', [LoginController::class, 'me']);
//    Route::get('logout', [LoginController::class, 'logout']);
//    Route::get('diary', function () {
//        $diaryEntries = DiaryEntry::with([
//            'diaryEntryIssue.issue:issuecode,title',
//            'diaryEntryStoryVersion:diary_entry_id,story_version_code',
//            'diaryEntryStoryVersion.storyVersion:storyversioncode,storycode',
//            'diaryEntryStoryVersion.storyVersion.story:storycode,title',
//        ])
//            ->where('user_id', Auth::id())
//            ->get();
//
//        return view('components/diary', [
//            'diaryEntries' => $diaryEntries,
//            'name' => Auth::id()
//        ]);
//    })->middleware('auth:web');
//});
