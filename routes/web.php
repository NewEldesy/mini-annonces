<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\MessageController;

// Page d'accueil - Liste des annonces (publique)
Route::get('/', [AdController::class, 'index'])->name('home');

// Routes pour les utilisateurs connectés
Route::middleware(['auth'])->group(function () {
    // Routes avec rate limiting
    Route::middleware(['throttle:6,1'])->group(function () {
        Route::get('/ads/create', [AdController::class, 'create'])->name('ads.create');
        Route::post('/ads', [AdController::class, 'store'])->name('ads.store');
        Route::get('/ads/{ad}/edit', [AdController::class, 'edit'])->name('ads.edit');
        Route::put('/ads/{ad}', [AdController::class, 'update'])->name('ads.update');
        Route::delete('/ads/{ad}', [AdController::class, 'destroy'])->name('ads.destroy');
    });

    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route pour le traitement des messages
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    
    // Routes Administrateur
    Route::middleware('can:admin')->prefix('admin')->name('admin.')->group(function () {
        // Dashboard admin
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Modération des annonces
        Route::post('/ads/{ad}/approve', [AdminController::class, 'approveAd'])->name('ads.approve');
        Route::post('/ads/{ad}/reject', [AdminController::class, 'rejectAd'])->name('ads.reject');
        Route::delete('/ads/{ad}', [AdminController::class, 'destroyAd'])->name('ads.destroy');
        
        // Gestion utilisateurs
        Route::post('/users/{user}/ban', [AdminController::class, 'banUser'])->name('users.ban');
        Route::post('/users/{user}/unban', [AdminController::class, 'unbanUser'])->name('users.unban');
        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    });
});

// Routes publiques pour les annonces (doivent être après /ads/create pour éviter les conflits)
Route::get('/ads', [AdController::class, 'index'])->name('ads.index');
Route::get('/ads/{ad}', [AdController::class, 'show'])->name('ads.show');

require __DIR__.'/auth.php';