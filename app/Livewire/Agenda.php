<?php

namespace App\Livewire;

use App\Livewire\Forms\AgendaVisitaForm;
use App\Models\{Agenda as Agenda_de_Visita, User};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\{Component, WithPagination};

class Agenda extends Component
{
    use WithPagination;

    public AgendaVisitaForm $form;

    public ?User $user = null;

    public $data_ini = null;

    public $data_fim = null;

    public function getAgenda()
    {

        $visitas = Agenda_de_Visita::query()->with('promotor')
            ->when(!$this->data_ini && !$this->data_fim, fn (Builder $q) => $q->where('date', 'like', '%' . date('Y-m') . '%'));

        if (Auth::user()->nivel_acesso == 3) {
            $visitas->where('id_user', Auth::user()->id);
        }

        if ($this->data_ini && $this->data_fim) {
            $visitas->whereBetween('date', [$this->data_ini, $this->data_fim]);
        }

        return $visitas->orderBy('date', 'desc')->paginate(6);
    }

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function pesquisar(): void
    {
        $this->getAgenda();
    }

    public function store()
    {

        $this->form->validate();

        // Adiciona o user_id ao array de dados
        $data            = $this->form->all();
        $data['id_user'] = $this->user->id;

        Agenda_de_Visita::create($data);

        return $this->redirectRoute('agenda');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $visitas = $this->getAgenda();

        return view('livewire.agenda', compact('visitas'));
    }
}
