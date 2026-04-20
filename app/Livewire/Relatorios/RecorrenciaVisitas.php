<?php

namespace App\Livewire\Relatorios;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class RecorrenciaVisitas extends Component
{

    use Interactions;

    public $data_ini;
    public $data_fim;
    public $meses;
    public $users;
    public $promotor;
    public $recorrencias = [];

    public function mount(){
        $this->data_ini = now()->startOfMonth()->format('Y-m-d');
        $this->data_fim = now()->format('Y-m-d');
        $this->users = User::select(['id','name'])
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => mb_convert_encoding($user->name, 'UTF-8', 'UTF-8'),
                ];
            })
            ->toArray();
    }

    public function getRecorrencia()
    {
        $prefix = DB::getTablePrefix();

        try{

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
                            FROM {$prefix}visitas v_ant
                            WHERE v_ant.cnpj = v.cnpj
                            AND v_ant.id_user = v.id_user
                            AND v_ant.date BETWEEN DATE_SUB( ?, INTERVAL ? MONTH)
                                                AND DATE_SUB( ?, INTERVAL 1 DAY)
                        ) THEN 'Sim'
                        ELSE 'Não'
                    END AS visitada_ultimos_meses
                FROM {$prefix}visitas v
                JOIN {$prefix}users p ON p.id = v.id_user
                WHERE v.date BETWEEN ? AND ?
                ";

            if(!empty($this->promotor)) {
                $sql .= " AND v.id_user = ?";
            }

            $sql .= " GROUP BY v.cnpj, v.id_user, p.name; ";


            $params = [
                $this->data_ini,
                $this->meses,
                $this->data_ini,
            ];

            if (!empty($this->promotor)) {
                $params[] = $this->data_ini;
                $params[] = $this->data_fim;
                $params[] = $this->promotor;
            } else {
                $params[] = $this->data_ini;
                $params[] = $this->data_fim;
            }


            $recorrencia = DB::select($sql, $params);
            return $recorrencia;

        }catch(\Exception $e){
            $this->dialog()->error('Atenção!', 'Erro ao buscar recorrência: ' . $e->getMessage())->send();
        }
    }

    public function pesquisar()
    {
        try {
            $this->validate([
                'data_ini' => 'required|date',
                'data_fim' => 'required|date',
                'meses' => 'required|integer|min:1',
            ]);

           $this->recorrencias = $this->getRecorrencia();
        } catch (\Illuminate\Validation\ValidationException $e) {

            $errors = $e->validator->errors();

            if ($errors->has('data_ini')) {
                $this->dialog()->info('Atenção',implode(' ', $errors->get('data_ini')))->send();
                return;
            }
            if ($errors->has('data_fim')) {
                $this->dialog()->info('Atenção',implode(' ', $errors->get('data_fim')))->send();
                return;
            }
            if ($errors->has('meses')) {
                $this->dialog()->info('Atenção',implode(' ', $errors->get('meses')))->send();
                return;
            }
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.relatorios.recorrencia-visitas');
    }
}
