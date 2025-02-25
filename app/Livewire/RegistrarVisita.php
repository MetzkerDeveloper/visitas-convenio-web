<?php

namespace App\Livewire;

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Livewire\Forms\RegistraVisitaForm;
use App\Models\Objetivo;
use App\Models\Regiao;
use App\Models\User;
use App\Models\Visita;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RegistrarVisita extends Component
{
    public bool $show = false;

    public ?User $user = null;

    public $objetivos = [];
    public $objetivo = null;

    public $regioes = [];

    public RegistraVisitaForm $form;

    public function __construct() {
        $this->user = Auth::user();
    }

    public function mount() {
        $this->objetivos = Objetivo::all();
        $this->regioes = Regiao::all();
    }

    public function setShow($param): void
    {
        $this->show = $param;
    }

    public function store() {
        $this->form->validate();
    
        // Adiciona o user_id ao array de dados
        $data = $this->form->all();
        $data['id_user'] = $this->user->id;
    
        Visita::create($data);
    
        return $this->redirect('/relatorio');
    }


    public function render()
    {
        return view('livewire.registrar-visita');
    }
}
