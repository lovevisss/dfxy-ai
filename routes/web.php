<?php

use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return redirect('/ai');
})->name('welcome');

//Route::get('links', function (){
//    return "this is the page for links";
//});

Route::resource('link', \App\Http\Controllers\LinkController::class);
Route::resource('ai', \App\Http\Controllers\AiController::class);
Route::resource('category', \App\Http\Controllers\CategoryController::class);
Route::resource('AiTools', \App\Http\Controllers\AiToolController::class);
Route::get('admin/aitools', [\App\Http\Controllers\AiToolController::class, 'manage'])
//    ->middleware('check.role:role')
    ->name('AiTools.manage');


Route::get('tag/{tag}', [\App\Http\Controllers\TagController::class, 'show']);

Route::get('/form/largePayment', function (){
    return view('form.largePayment');
});

Route::get('about', [\App\Http\Controllers\PublicController::class, 'about'])->name('about');

Route::get('post/{id}', [\App\Http\Controllers\PostController::class, 'show'])->name('single_post');
Route::get('contact', [\App\Http\Controllers\PublicController::class, 'contact'])->name('contact');

Route::prefix('user')->group(
    function (){
        Route::get('dashboard', [\App\Http\Controllers\PublicController::class,'index']);
    }

);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('admin', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
