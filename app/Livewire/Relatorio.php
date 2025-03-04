<?php

namespace App\Livewire;

use App\Models\{Objetivo, Regiao, Visita};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\{Layout, On};
use Livewire\{Component, WithPagination};

class Relatorio extends Component
{
    use WithPagination;

    public $objetivos = [];

    public $objetivo = null;

    public $regioes = [];

    public $regiao = null;

    public $data_ini = null;

    public $data_fim = null;

    public bool $show = false;

    public function mount()
    {
        $this->objetivos = Objetivo::all();
        $this->regioes   = Regiao::all();
    }

    public function getVisitas()
    {
        $visitas = Visita::query()->with(['objetivo', 'regiao', 'promotor'])
            ->when(!$this->data_ini && !$this->data_fim, fn (Builder $q) => $q->where('date', 'like', '%' . date('Y-m') . '%'))
            ->when($this->regiao, fn (Builder $q) => $q->where('id_region', '=', $this->regiao))
            ->when($this->objetivo, fn (Builder $q) => $q->where('id_objective', '=', $this->objetivo));

        if ($this->data_ini && $this->data_fim) {
            $visitas->whereBetween('date', [$this->data_ini, $this->data_fim]);
        }

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
