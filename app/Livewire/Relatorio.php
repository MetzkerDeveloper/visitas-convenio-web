<?php

namespace App\Livewire;

use App\Models\Objetivo;
use App\Models\Regiao;
use App\Models\Visita;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Relatorio extends Component
{
    use WithPagination;

    public $objetivos = [];
    public $objetivo = null;
    public $regioes = [];
    public $regiao = null;
    public $data = null;
    public bool $show = false;

    public function mount()
    {
        $this->objetivos = Objetivo::all();
        $this->regioes = Regiao::all();
    }

    public function getVisitas()
    {
        $visitas = Visita::query()->with(['objetivo', 'regiao', 'promotor'])
            ->when($this->regiao, fn (Builder $q) => $q->where('id_region', '=', $this->regiao))
            ->when($this->objetivo, fn (Builder $q) => $q->where('id_objective', '=', $this->objetivo))
            ->when($this->data, fn (Builder $q) => $q->where('date', '=', $this->data));

        if (Auth::user()->nivel_acesso == 3) {
            $visitas->where('id_user', Auth::user()->id);
        }

        return $visitas->orderBy('id', 'desc')->paginate(8);
    }

    public function pesquisar(): void
    {
        $this->getVisitas();
    }

    public function show_visita($id)
    {
        $visita = Visita::query()->with(['objetivo', 'regiao', 'promotor'])->find($id);

        return view('livewire.editar-visita', ['visita' => $visita]);
    }

    #[Layout("layouts.app"), On('vista:created')]
    public function render()
    {
        $visitas = $this->getVisitas();
        return view('livewire.relatorio', compact('visitas'));
    }

}
