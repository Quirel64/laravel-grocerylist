<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PremiumController;

Route::post('/premium/activate', [PremiumController::class, 'upgrade'])->name('premium.activate');
//Route::post('/premium/deactivate', [PremiumController::class, 'downgrade'])->name('premium.deactivate');
Route::post('/premium/deactivate', [PremiumController::class, 'downgrade'])
    ->middleware('auth')
    ->name('premium.deactivate');


Route::get('/premium', function () {return view('items.premium');})->name('premium');


Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


//register routes
Route::get('/register', function () {
    return view('items.register');
})->name('register');

Route::post('/register', [RegisterController::class, 'register']);


//login routes
Route::get('/login', function () {
    return view('items.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');



//*
//!.gitignore


Route::get('/items', function () {
    return 'items.index';
})->name('items.index');

Route::get('/items/create', function () {
    return 'items.create';
})->name('items.create');

Route::get('/items', [ItemController::class, 'index'])->name('items.index');
Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');

Route::post('/items', [ItemController::class, 'store'])->name('items.store');
Route::get('/items/{id}', function () {})->name('items.show');
Route::get('/items/{id}/edit', function () {})->name('items.edit');
Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update');
Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');
Route::get('/items/{id}/edit', [ItemController::class, 'edit'])->name('items.edit');

//Category routes

Route::get('/categories', function () { return view('items.category'); })->name('items.category');

Route::get('/categories', [CategoryController::class, 'index'])->name('items.category');
Route::post('/categories', [CategoryController::class, 'store'])->name('category.store');
Route::delete('/categories{category}', [CategoryController::class, 'destroy'])->name('category.destroy');

// comment routes
Route::get('/items/{id}/comments', [CommentController::class, 'create'])->name('items.comments');
Route::middleware('auth')->post('/comments', [CommentController::class, 'store'])->name('comments.store');


//app\Http\Controllers\CommentController.php

// We voegen ook een redirect toe aan de routes die de hoofdpagina doorverwijst naar de '/items' route
Route::redirect('/', '/items');