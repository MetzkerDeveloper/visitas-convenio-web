<?php

namespace App\Livewire\Relatorios;

use App\Exports\ComissoesExport;
use App\Traits\SweetAlert;
use Illuminate\Support\Facades\{DB};
use Livewire\Attributes\{Layout, Validate};
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use TallStackUi\Traits\Interactions;

class ComissaoVisitas extends Component
{
    use Interactions;

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
                        DB::raw('COUNT(CASE WHEN o.id = 1 THEN 1 END) AS captacao'),
                        DB::raw('COUNT(CASE WHEN o.id = 2 THEN 1 END) AS loja'),
                        DB::raw('COUNT(CASE WHEN o.id = 3 THEN 1 END) AS manutencao'),
                        DB::raw("(COUNT(v.id) * param.value) AS total_a_pagar")
                    )
                    ->whereBetween('v.date', [$this->dataIni, $this->dataFim])
                    ->groupBy('p.id', 'p.name', 'r.name')
                    ->get();
    }

    public function pesquisar()
    {
        try {
            $this->validate();
            $this->getComissao();
        }catch (\Illuminate\Validation\ValidationException $e){
            $errors = $e->validator->errors();

            if ($errors->has('dataIni')) {
                $this->dialog()->info('Atenção','O campo Data Inicial é obrigatório')->send();
                return;
            }

            if ($errors->has('dataFim')) {
                $this->dialog()->info('Atenção', 'O campo Data Final é obrigatório')->send();
                return;
            }


        }
    }

    public function download()
    {
        if (!$this->dataIni || !$this->dataFim) {
            $this->dialog()->warning('Atenção', 'Preencha as datas iniciais e finais para baixar o relatório! corretamente')->send();
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
