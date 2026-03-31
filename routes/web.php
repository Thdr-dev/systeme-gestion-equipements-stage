<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FamilleController;
use App\Http\Controllers\MaterielController;
use App\Http\Controllers\MouvementController;
use App\Http\Controllers\SousFamilleController;
use App\Http\Controllers\UniteController;
use Illuminate\Support\Facades\Auth;

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

    Route::resource('familles', FamilleController::class);
    Route::resource('sous-familles', SousFamilleController::class);
    Route::resource('unites', UniteController::class);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
  
    
    Route::get('/mouvements/create/{materiel}', [MouvementController::class, 'create'])->name('mouvements.create')->withoutMiddleware("admin");
    Route::get('/mouvements/declarePanne/{materiel}', [MouvementController::class, 'declarePanne'])->name('mouvements.declarePanne')->withoutMiddleware("admin");
    Route::post('/mouvements', [MouvementController::class, 'store'])->name('mouvements.store')->withoutMiddleware("admin");

    
    Route::get('/notifications/read-all', function() {
        Auth::user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.readAll');

    Route::get('/api/notifications/data', function() {
        $user = Auth::user();
        return response()->json([
            'count' => $user->unreadNotifications->count(),
            'html'  => view('partials.notifications_list')->render() 
        ]);
    });
    
    Route::get('/notifications/{id}/read', function($id) {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead(); // Elle disparaitra de 'unreadNotifications'
        
        return redirect($notification->data['link']); 
    })->name('notifications.markAsRead');


});


Route::middleware("guest")->group(function(){
    Route::get('/login', [AuthController::class, 'showLogin'])->name('users.login');
    Route::post('/login', [AuthController::class, 'login']);
});


Route::resource('materiels', MaterielController::class); // deja contient les middlewares dans le controlleur