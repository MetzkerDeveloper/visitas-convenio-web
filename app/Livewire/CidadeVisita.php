<?php

namespace App\Livewire;

use App\Models\{Objetivo, Regiao, User, Visita};
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CidadeVisita extends Component
{

    public $usuarios = [];

    public $usuario = null;

    public $regioes = [];

    public $regiao = null;

    public $data_ini = null;

    public $data_fim = null;

    public bool $show = false;

    public function mount()
    {
        $this->usuarios  = User::all();
        $this->regioes   = Regiao::all();
    }
    
    private function getCidadeVisitada()
    {
        $sql = "
            SELECT DISTINCT 
                p.name AS promotor, 
                a.city AS cidade_agendada, 
                COALESCE(v.city, 'Não visitou') AS cidade_visitada
            FROM visitas_convenio_agendas a
            JOIN visitas_convenio_users p ON a.id_user = p.id
            LEFT JOIN visitas_convenio_visitas v 
                ON a.id_user = v.id_user 
                AND v.city LIKE CONCAT('%', a.city, '%')
            WHERE a.date BETWEEN ? AND ?
        
            UNION
        
            SELECT DISTINCT 
                p.name AS promotor, 
                'Cidade não agendada' AS cidade_agendada, 
                v.city AS cidade_visitada
            FROM visitas_convenio_visitas v
            JOIN visitas_convenio_users p ON v.id_user = p.id
            WHERE NOT EXISTS (
                SELECT 1 
                FROM visitas_convenio_agendas a
                WHERE a.id_user = v.id_user 
                AND a.city LIKE CONCAT('%', v.city, '%') 
                AND a.date BETWEEN ? AND ?
            )
        ";
    return DB::select($sql, [$this->data_ini, $this->data_fim, $this->data_ini, $this->data_fim]);
    
    }
    
    
    public function pesquisar(): void
    {
        $this->getCidadeVisitada();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $cidadeVisitas = $this->getCidadeVisitada();

        return view('livewire.cidade-visita', compact('cidadeVisitas'));
    }
}
