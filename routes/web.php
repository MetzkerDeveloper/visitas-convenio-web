<?php

use App\Livewire\{Agenda, ConvenioPorPromotor, Params, Visita, Usuarios};
use App\Livewire\Dashboards\Dashboard;
use App\Livewire\Relatorios\{CidadeVisita, ComissaoVisitas, RecorrenciaVisitas};
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
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

Route::middleware('verified','auth')->group(function () {

    Route::get('/visitas', Visita::class)
    ->name('visitas');

    Route::get('/visita/{id}', [Visita::class, 'show_visita'])
    ->name('editar-visita');

    Route::view('home', 'home')
    ->middleware(['verified','auth'])
    ->name('home');

    Route::get('profile', function () {
        return view('profile', ['request' => request() ]);
    })->middleware(['verified','auth'])
    ->name('profile');

    Route::get('/agenda', Agenda::class)
    ->name('agenda');

    Route::get('/usuarios', Usuarios::class)
    ->name('usuarios');

    Route::get('/parametros', Params::class)
    ->name('parametros');

    Route::get('/comissao', ComissaoVisitas::class)
    ->name('comissao');

    Route::get('/visitar', ConvenioPorPromotor::class)
    ->name('visitar');

    Route::get('/cidade-visitada', CidadeVisita::class)
    ->name('cidade-visitada');

    Route::get('/recorrencia-visitas', RecorrenciaVisitas::class)
    ->name('recorrencia-visitas');

    Route::get('/dashboard', Dashboard::class)
    ->name('dashboard');

    /*
    Route::get('/2fa', function () {
        return view('livewire.profile.two-fa');
    })->name('2fa'); 
    */

    Route::get('api/users', function (Request $request) {
          $search = $request->get('search');
           $selected = $request->get('selected');
 
    return User::query()
        ->when($selected, fn ($query) => $query->orWhere('id', $selected))
        ->when($search, fn (Builder $query) => $query->where('name', 'like', "%{$search}%"))
        ->unless($search, fn (Builder $query) => $query->limit(10))
        ->orderBy('name')
        ->get()
        ->map(fn (User $user): array => [
            'label' => $user->name,
            'value' => $user->id,
        ]);
    })->name('api.users');

});

require __DIR__ . '/auth.php';
