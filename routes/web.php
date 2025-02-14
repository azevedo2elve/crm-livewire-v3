<?php

use App\Livewire\Auth\{Login, Register};
use App\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

// Ao chamar o componente do livewire ele precisa da view layout do component que por padrão  components.layout.app, pode fazer com o php artisan livewire:layout
Route::get('/', Welcome::class)->name('dashboard');
Route::get('/register', Register::class)->name('auth.register');
Route::get('/login', Login::class)->name('auth.login');
Route::get('/logout', fn () => Auth::logout());
