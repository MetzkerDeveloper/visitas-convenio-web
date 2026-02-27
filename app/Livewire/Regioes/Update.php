<?php

namespace App\Livewire\Regioes;

use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Update extends Component
{
    use Interactions;
    public $regiao;
    public $newName;
    public $show = false;

    public function update()
    {
        $this->validate([
            'regiao.name' => 'required|string|max:255',
        ]);

        $this->regiao->name = strtoupper($this->newName);

        $this->regiao->save();

        $this->dialog()->success('Sucesso!', "Região {$this->regiao->name} atualizada com sucesso!")->send();

        $this->show = false;
        $this->reset('newName');
        $this->dispatch('refresh::regioes');
    }

    public function render()
    {
        return view('livewire.regioes.update');
    }
}
