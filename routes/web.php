<?php

use App\Livewire\{Agenda, Params, Visita, Usuarios};
use App\Livewire\Dashboards\Dashboard;
use App\Livewire\Relatorios\{CidadeVisita, ComissaoVisitas, RecorrenciaVisitas};
use Illuminate\Support\Facades\{Auth, Route};
use Livewire\Livewire;

/*if(env('APP_ENV') !== 'local') {
    Livewire::setUpdateRoute(function ($handle) {
        return Route::post('visitas-convenio/livewire/update', $handle);
    });

    Livewire::setScriptRoute(function ($handle) {
      return Route::get('visitas-convenio/livewire/livewire.js', $handle);
    });
}*/

Route::get('/', function () {

    if (app()->isLocal()) {
        Auth::loginUsingId(1);

        return to_route('home');
    }

    return to_route('login');
});

Route::middleware('auth')->group(function () {

    Route::get('/visitas', Visita::class)
    ->name('visitas');

    Route::get('/visita/{id}', [Visita::class, 'show_visita'])
    ->name('editar-visita');

    Route::view('home', 'home')
    ->middleware(['verified'])
    ->name('home');

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

    Route::get('/cidade-visitada', CidadeVisita::class)
    ->name('cidade-visitada');

    Route::get('/recorrencia-visitas', RecorrenciaVisitas::class)
    ->name('recorrencia-visitas');

    Route::get('/dashboard', Dashboard::class)
    ->name('dashboard');

});

require __DIR__ . '/auth.php';
