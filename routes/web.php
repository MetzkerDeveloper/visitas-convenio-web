<?php

use App\Livewire\Agenda;
use App\Livewire\ComissaoVisitas;
use App\Livewire\Relatorio;
use App\Livewire\Usuarios;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return redirect('login');
});

Route::get('/relatorio', Relatorio::class)
    ->middleware(['auth'])
    ->name('relatorio');

Route::get('/relatorio/{id}', [Relatorio::class, 'show_visita'])
    ->middleware(['auth'])
    ->name('editar-visita');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/agenda', Agenda::class)
->middleware(['auth'])
->name('agenda');

Route::get('/usuarios', Usuarios::class)
->middleware(['auth'])
->name('usuarios');

Route::get('/comissao', ComissaoVisitas::class)
->middleware(['auth'])
->name('comissao');



require __DIR__.'/auth.php';
