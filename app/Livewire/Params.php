<?php

namespace App\Livewire;

use App\Models\Parametro;
use App\Traits\SweetAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Params extends Component
{

    use SweetAlert;

    public $parametros;

    public $valores = [];

    

    public function mount(){
        
        $this->parametros = Parametro::all();

        foreach ($this->parametros as $parametro) {
            $this->valores[$parametro->id] = $parametro->value;
        }
    }


    public function update($id){

        $parametro = Parametro::find($id);
        
        if ($parametro) {
            $parametro->value = $this->valores[$id];
            $parametro->save();
        }

         // Atualiza a lista de parâmetros (opcional)
         $this->parametros = Parametro::all();
         
         $this->success("Valor do parametro $parametro->name, foi atualizado com sucesso!");
         
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.params');
    }
}
