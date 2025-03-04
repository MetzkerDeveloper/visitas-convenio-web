<?php

namespace App\Livewire;

use App\Models\{Nivel, Regiao, User};
use Livewire\Component;

class EditarUsuario extends Component
{
    public bool $show = false;

    public ?User $user = null;

    public ?string $nome = null;

    public ?string $nivel = null;

    public ?string $regiao = null;

    public $niveis;

    public $regioes;

    public function mount(User $user): void
    {

        $this->authorize('isAdmin');

        $this->user    = $user;
        $this->nome    = $this->user->name;
        $this->nivel   = $this->user->nivel_acesso;
        $this->regiao  = $this->user->id_region;
        $this->niveis  = Nivel::all();
        $this->regioes = Regiao::all();
    }

    public function setShow($param): void
    {
        $this->show = $param;
    }

    public function edit()
    {

        $this->user->nivel_acesso = $this->nivel;
        $this->user->id_region    = $this->regiao;

        $this->user->save();

        $this->setShow(false);
        $this->dispatch('user::updated');
    }

    public function render()
    {
        return view('livewire.editar-usuario');
    }
}
