<?php

namespace App\Livewire\Relatorios;

use App\Models\{ Regiao, User};
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use TallStackUi\Traits\Interactions;

class CidadeVisita extends Component
{
    use Interactions;

    public $usuarios = [];

    public $usuario = null;

    public $regioes = [];

    public $regiao = null;

    public $data_ini = null;

    public $data_fim = null;

    public bool $show = false;

    public function mount()
    {
        $this->usuarios  = User::whereStatus(true)->get();
        $this->regioes   = Regiao::all();
    }

    private function getCidadeVisitada()
    {
        $prefix = DB::getTablePrefix();

        $sql = "
            SELECT DISTINCT
                p.name AS promotor,
                a.city AS cidade_agendada,
                COALESCE(v.city, 'Não visitou') AS cidade_visitada
            FROM {$prefix}agendas a
            JOIN {$prefix}users p ON a.id_user = p.id
            LEFT JOIN {$prefix}visitas v
                ON a.id_user = v.id_user
                AND v.city LIKE CONCAT('%', a.city, '%')
            WHERE a.date BETWEEN ? AND ?

            UNION

            SELECT DISTINCT
                p.name AS promotor,
                'Cidade não agendada' AS cidade_agendada,
                v.city AS cidade_visitada
            FROM {$prefix}visitas v
            JOIN {$prefix}users p ON v.id_user = p.id
            WHERE NOT EXISTS (
                SELECT 1
                FROM {$prefix}agendas a
                WHERE a.id_user = v.id_user
                AND a.city LIKE CONCAT('%', v.city, '%')
                AND a.date BETWEEN ? AND ?
            )
        ";
    return DB::select($sql, [$this->data_ini, $this->data_fim, $this->data_ini, $this->data_fim]);

    }


    public function pesquisar(): void
    {

        try {
            $this->validate(['data_ini' => 'required|date', 'data_fim' => 'required|date']);

            $this->getCidadeVisitada();
        }catch (\Illuminate\Validation\ValidationException $e){
            $errors = $e->validator->errors();

            if ($errors->has('data_ini')) {
                $this->dialog()->info('Atenção','O campo Data Inicial é obrigatório')->send();
                return;
            }

            if ($errors->has('data_fim')) {
                $this->dialog()->info('Atenção', 'O campo Data Final é obrigatório')->send();
                return;
            }
        }

    }

    #[Layout('layouts.app')]
    public function render()
    {
        $cidadeVisitas = $this->getCidadeVisitada();

        return view('livewire.relatorios.cidade-visita', compact('cidadeVisitas'));
    }
}
