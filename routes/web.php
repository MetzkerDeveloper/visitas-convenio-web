<?php

use App\Livewire\{Agenda, ComissaoVisitas, Params, Visita, Usuarios};
use Illuminate\Support\Facades\{Auth, Route};
use Livewire\Livewire;


Livewire::setUpdateRoute(function ($handle) {
   return Route::post('visitas-convenio/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
 return Route::get('visitas-convenio/livewire/livewire.js', $handle);
});


Route::get('/', function () {

    if (app()->isLocal()) {
        Auth::loginUsingId(1);

        return to_route('dashboard');
    }

    return to_route('login');
});

Route::middleware('auth')->group(function () {

    Route::get('/visitas', Visita::class)
    ->name('visitas');

    Route::get('/visita/{id}', [Visita::class, 'show_visita'])
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

    Route::get('/parametros', Params::class)
    ->name('parametros');

    Route::get('/comissao', ComissaoVisitas::class)
    ->name('comissao');

});

require __DIR__ . '/auth.php';
