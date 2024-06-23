<?php

use App\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Ao chamar o componente do livewire ele precisa da view layout do component que por padrão  components.layout.app, pode fazer com o php artisan livewire:layout
Route::get('/', Welcome::class);
