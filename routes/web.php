<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FamilleController;
use App\Http\Controllers\MaterielController;
use App\Http\Controllers\SousFamilleController;
use App\Http\Controllers\UniteController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(["auth", "admin"])->group(function(){
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::name("users.")->group(function(){
        
        Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->withoutMiddleware("admin");

        Route::get('/users', [AuthController::class, 'getUsers'])->name('index');
        Route::get('/users/{user}', [AuthController::class, 'editUser'])->name("edit");
        Route::put('/users/{user}', [AuthController::class, 'updateUser'])->name("update");
        Route::delete('/users/{user}', [AuthController::class, 'deleteUser'])->name("delete");


        });
        
        });
        
        
Route::middleware("guest")->group(function(){
    Route::get('/login', [AuthController::class, 'showLogin'])->name('users.login');
    Route::post('/login', [AuthController::class, 'login']);
});



Route::resource('familles', FamilleController::class)->middleware(["auth", "admin"]);
Route::resource('sous-familles', SousFamilleController::class)->middleware(["auth", "admin"]);
Route::resource('unites', UniteController::class)->middleware(["auth", "admin"]);

Route::resource('materiels', MaterielController::class)->middleware(["auth"]);