<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Propiedades\Index as PropiedadesIndex;
use App\Livewire\Inquilinos\Index as InquilinosIndex;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});
Route::get('/propiedades', PropiedadesIndex::class)->name('propiedades.index');
Route::get('/inquilinos', InquilinosIndex::class)->name('inquilinos.index');
require __DIR__.'/settings.php';
