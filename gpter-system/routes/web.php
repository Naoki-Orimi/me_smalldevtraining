<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// タスク関連のルート
Route::get('/tasks/index', [App\Http\Controllers\TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/create', [App\Http\Controllers\TaskController::class, 'create'])->name('tasks.create');
Route::post('/tasks', [App\Http\Controllers\TaskController::class, 'store'])->name('tasks.store');
Route::get('/tasks/detail/{id}', [App\Http\Controllers\TaskController::class, 'show'])->name('tasks.show');

// タスクAPI（モーダル用）
Route::get('/api/tasks/{id}', [App\Http\Controllers\TaskController::class, 'apiShow']);

// プロジェクト関連のルート（将来の機能）
Route::get('/projects', function () {
    return redirect()->route('home')->with('info', '次のアップデートをお待ちください');
})->name('projects.index');

// チーム関連のルート（将来の機能）
Route::get('/teams', function () {
    return redirect()->route('home')->with('info', '次のアップデートをお待ちください');
})->name('teams.index');
