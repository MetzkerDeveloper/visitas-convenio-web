<?php

namespace App\Livewire\Relatorios;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

class RecorrenciaVisitas extends Component
{
    public $data_ini;
    public $data_fim;
    public $meses;

    public function getRecorrencia()
    {
        $sql = "
        SELECT 
            p.name AS promotor,
            v.cnpj,
            MAX(v.enterprise) AS enterprise, 
            MAX(v.date) AS data_ultima_visita,
            COUNT(*) AS visitas_no_periodo,
            CASE 
                WHEN EXISTS (
                    SELECT 1 
                    FROM visitas_convenio_visitas v_ant
                    WHERE v_ant.cnpj = v.cnpj
                    AND v_ant.id_user = v.id_user
                    AND v_ant.date BETWEEN DATE_SUB( ?, INTERVAL ? MONTH) 
                                        AND DATE_SUB( ?, INTERVAL 1 DAY)
                ) THEN 'Sim'
                ELSE 'Não'
            END AS visitada_ultimos_meses
        FROM visitas_convenio_visitas v
        JOIN visitas_convenio_users p ON p.id = v.id_user
        WHERE v.date BETWEEN ? AND ?
        GROUP BY v.cnpj, v.id_user, p.name;
        ";

        $params = [
            $this->data_ini,
            $this->meses,
            $this->data_ini,
            $this->data_ini,
            $this->data_fim
        ];

        $recorrencia = DB::select($sql, $params);

        return $recorrencia;
    }

    public function pesquisar()
    {
        $this->getRecorrencia();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $recorrencias = $this->getRecorrencia();
        return view('livewire.relatorios.recorrencia-visitas', compact('recorrencias'));
    }
}
