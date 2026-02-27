<?php

namespace App\Livewire\Regioes;

use App\Models\Regiao;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Create extends Component
{
    use Interactions;
    
    public $show = false;
    public $name;

    public function create()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        Regiao::create([
            'name' => strtoupper($this->name),
        ]);

        $this->dialog()->success('Sucesso!', "Região {$this->name} criada com sucesso!")->send();

        $this->reset('name');
        $this->dispatch('refresh::regioes');
    }

    public function render()
    {
        return view('livewire.regioes.create');
    }
}
