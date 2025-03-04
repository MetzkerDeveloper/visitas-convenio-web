<?php

use App\Livewire\{Agenda, ComissaoVisitas, Params, Relatorio, Usuarios};
use Illuminate\Support\Facades\{Auth, Route};

Route::get('/', function () {

    if (app()->isLocal()) {
        Auth::loginUsingId(1);

        return to_route('dashboard');
    }

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

    Route::get('/parametros', Params::class)
    ->name('parametros');

    Route::get('/comissao', ComissaoVisitas::class)
    ->name('comissao');

});

require __DIR__ . '/auth.php';
