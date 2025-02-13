<?php

use App\Livewire\Auth\Register;
use App\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

// Ao chamar o componente do livewire ele precisa da view layout do component que por padrão  components.layout.app, pode fazer com o php artisan livewire:layout
Route::get('/', Welcome::class);
Route::get('/register', Register::class)->name('auth.register');
Route::get('/logout', fn () => Auth::logout());
