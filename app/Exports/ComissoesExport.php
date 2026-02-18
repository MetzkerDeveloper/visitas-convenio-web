<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings};

class ComissoesExport implements FromCollection, WithHeadings
{
    private $dataIni;

    private $dataFim;

    public function __construct($dataIni, $dataFim)
    {
        $this->dataIni = $dataIni;
        $this->dataFim = $dataFim;
    }

    public function headings(): array
    {
        return [
            'promotor',
            'regiao',
            'captacao',
            'loja',
            'manutencao',
            'total_a_pagar',
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('visitas as v')
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
}
