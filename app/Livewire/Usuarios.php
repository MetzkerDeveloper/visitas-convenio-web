<?php

namespace App\Livewire;

use App\Livewire\Forms\CadastroUsuarioForm;
use App\Models\Nivel;
use App\Models\Regiao;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Usuarios extends Component
{

    use WithPagination;

    public bool $show = false;

    public CadastroUsuarioForm $form;

    public $niveis;

    public $regioes;


    public function mount(): void
    {

        $this->authorize('isAdmin');

        $this->niveis  = Nivel::all();
        $this->regioes  = Regiao::all();
    }

    public function setShow($param): void
    {
        $this->show = $param;
    }

    public function getUser(){
        return User::paginate(10);
    }

    public function store(){

        $this->form->validate();

        $data = $this->form->all();

        $user = [
            'id_region' => $data['id_region'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'nivel_acesso' => $data['nivel_acesso'],
        ];

        //dd($user);

        User::query()->create($user);

        return redirect('/usuarios');
    }

    #[Layout('layouts.app'),On('user::updated')]
    public function render()
    {
        $users = $this->getUser();
        return view('livewire.usuarios', compact('users'));
    }
}
