<?php

namespace App\Livewire\Relatorios;

use App\Exports\ComissoesExport;
use App\Traits\SweetAlert;
use Illuminate\Support\Facades\{DB};
use Livewire\Attributes\{Layout, Validate};
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class ComissaoVisitas extends Component
{
    use SweetAlert;

    #[Validate('required')]
    public $dataIni;

    #[Validate('required')]
    public $dataFim;

    public function getComissao()
    {
        return  DB::table('visitas as v')
                    ->join('users as p', 'v.id_user', '=', 'p.id')
                    ->join('objetivos as o', 'v.id_objective', '=', 'o.id')
                    ->join('regiaos as r', 'v.id_region', '=', 'r.id')
                    ->join('parametros as param', 'param.id', '=', DB::raw(1))
                    ->select(
                        'p.name as promotor',
                        'r.name as regiao',
                        DB::raw('COUNT(CASE WHEN visitas_convenio_o.id = 1 THEN 1 END) AS captacao'),
                        DB::raw('COUNT(CASE WHEN visitas_convenio_o.id = 2 THEN 1 END) AS loja'),
                        DB::raw('COUNT(CASE WHEN visitas_convenio_o.id = 3 THEN 1 END) AS manutencao'),
                        DB::raw("(COUNT(visitas_convenio_v.id) * visitas_convenio_param.value) AS total_a_pagar")
                    )
                    ->whereBetween('v.date', [$this->dataIni, $this->dataFim])
                    ->groupBy('p.id', 'p.name', 'r.name')
                    ->get();
    }

    public function pesquisar()
    {
        $this->validate();
        $this->getComissao();
    }

    public function download()
    {
        if (!$this->dataIni || !$this->dataFim) {
            $this->error('Preencha as datas iniciais e finais para baixar o relatório! corretamente');

            return;
        }

        $fileName = "comissao_de_" . $this->dataIni . "_a_" . $this->dataFim . ".xlsx";

        return Excel::download(new ComissoesExport($this->dataIni, $this->dataFim), $fileName);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $comissoes = $this->getComissao();

        return view('livewire.relatorios.comissao-visitas', compact('comissoes'));
    }
}
