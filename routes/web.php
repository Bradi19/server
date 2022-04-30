<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProjectsController;
use Illuminate\Support\Facades\Route;

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
Route::get('/login', view('auth.login'));
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/admin/auth', [BannerController::class, 'autificate']);
#::middleware(['auth'])->
Route::middleware(['Auth'])->prefix('admin')->group(function(){
    Route::get('/', [BannerController::class, 'index']);
    Route::get('/addBanner', [BannerController::class, 'addBanner']);
    Route::get('/addProject', [ProjectsController::class, 'index']);
    Route::get('/addNews', [NewsController::class, 'index']);
    Route::prefix('/banner')->group(function(){
        Route::post('/add', [BannerController::class, 'add']);
        Route::post('/remove', [BannerController::class, 'remove']);
        Route::post('/edit', [BannerController::class, 'edit']);
    });
    Route::prefix('/project')->group(function(){
        Route::post('/getData', [ProjectsController::class, 'getData']);
        Route::post('/add', [ProjectsController::class, 'add']);
        Route::post('/remove', [ProjectsController::class, 'remove']);
        Route::post('/edit', [ProjectsController::class, 'edit']);
    });
    Route::prefix('/news')->group(function(){
        Route::post('/getData', [NewsController::class, 'getData']);
        Route::post('/add', [NewsController::class, 'add']);
        Route::post('/remove', [NewsController::class, 'remove']);
        Route::post('/edit', [NewsController::class, 'edit']);
    });
});
// Route::get('/login', function () {
//     return view('login');
// })->name('login');
// Route::get('/login', [BannerController::class, 'index'])->name('login');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
