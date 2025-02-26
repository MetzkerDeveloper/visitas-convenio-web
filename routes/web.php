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

Route::middleware('auth')->group(function () {

    Route::get('/relatorio', Relatorio::class)
    ->name('relatorio');

    Route::get('/relatorio/{id}', [Relatorio::class, 'show_visita'])
    ->name('editar-visita');

    Route::view('dashboard', 'dashboard')
    ->middleware(['verified'])
    ->name('dashboard');

    Route::view('profile', 'profile')
    ->name('profile');

    Route::get('/agenda', Agenda::class)
    ->name('agenda');

    Route::get('/usuarios', Usuarios::class)
    ->name('usuarios');

    Route::get('/comissao', ComissaoVisitas::class)
    ->name('comissao');

});


require __DIR__.'/auth.php';
