<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ComissaoVisitas extends Component
{
    #[Validate('required')]
    public  $dataIni ;

    #[Validate('required')]
    public  $dataFim;


    public function getComissao(){
        return  DB::table('visitas as v')
                    ->join('users as p', 'v.id_user', '=', 'p.id')
                    ->join('objetivos as o', 'v.id_objective', '=', 'o.id')
                    ->select(
                        'p.name as promotor',
                        DB::raw('COUNT(CASE WHEN o.id = 1 THEN 1 END) AS captacao'),
                        DB::raw('COUNT(CASE WHEN o.id = 2 THEN 1 END) AS loja'),
                        DB::raw('COUNT(CASE WHEN o.id = 3 THEN 1 END) AS manutencao'),
                        DB::raw('(COUNT(v.id) * 2) AS total_a_pagar')
                    )
                    ->whereBetween('v.date', [$this->dataIni, $this->dataFim])
                    ->groupBy('p.id', 'p.name')
                    ->get();  
    }

    public function pesquisar(){
        $this->validate();
        $this->getComissao();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $comissoes = $this->getComissao();
        return view('livewire.comissao-visitas', compact('comissoes'));
    }
}
