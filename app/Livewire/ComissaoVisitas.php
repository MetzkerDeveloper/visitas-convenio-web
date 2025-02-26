<?php

namespace App\Livewire;

use App\Exports\ComissoesExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

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
                    ->join('regiaos as r', 'v.id_region', '=', 'r.id')
                    ->select(
                        'p.name as promotor',
                        'r.name as regiao',
                        DB::raw('COUNT(CASE WHEN visitas_convenio_o.id = 1 THEN 1 END) AS captacao'),
                        DB::raw('COUNT(CASE WHEN visitas_convenio_o.id = 2 THEN 1 END) AS loja'),
                        DB::raw('COUNT(CASE WHEN visitas_convenio_o.id = 3 THEN 1 END) AS manutencao'),
                        DB::raw('(COUNT(visitas_convenio_v.id) * 2) AS total_a_pagar')
                    )
                    ->whereBetween('v.date', [$this->dataIni, $this->dataFim])
                    ->groupBy('p.id', 'p.name','r.name')
                    ->get();
    }

    public function pesquisar(){
        $this->validate();
        $this->getComissao();
    }

    public function download()
    {
        $this->validate();
        
        $fileName = "comissao_de_".$this->dataIni ."_a_".$this->dataFim. ".xlsx";
        return Excel::download(new ComissoesExport($this->dataIni, $this->dataFim), $fileName);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $comissoes = $this->getComissao();
        return view('livewire.comissao-visitas', compact('comissoes'));
    }
}
