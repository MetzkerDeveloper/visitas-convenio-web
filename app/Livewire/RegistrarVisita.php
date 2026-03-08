<?php

namespace App\Livewire;

use App\Livewire\Forms\RegistraVisitaForm;
use App\Models\{Objetivo, Regiao, User, Visita};
use App\Traits\{Functions, SweetAlert, Toastify};
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class RegistrarVisita extends Component
{
    use Interactions;
    use Functions;

    public bool $show = false;

    public ?User $user = null;

    public $objetivos = [];

    public $objetivo = null;

    public $regioes = [];

    public RegistraVisitaForm $form;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function mount()
    {
        $this->objetivos = Objetivo::all();
        $this->regioes   = Regiao::all();
    }

    public function setShow($param): void
    {
        $this->show = $param;
    }

    public function store()
    {

        $this->form->validate();

        $dateIsValid = $this->validateVisitDate($this->form->date);

        if (!$dateIsValid) {
            $this->setShow(false);
            $this->dialog()->warning('Atenção', 'Não é possível registrar visita para esta data. 
            Contate o gestor para mais informações.')->send();
            return;
        }

        // Adiciona o user_id ao array de dados
        $data            = $this->form->all();
        $data['id_user'] = $this->user->id;

        Visita::create($data);
        $this->dialog()->success('Sucesso!','Visita registrada com sucesso!')->send();
        $this->dispatch('visita:created');
        $this->setShow(false);
        $this->form->reset();
    }

    public function render()
    {
        return view('livewire.registrar-visita');
    }
}
