<?php

namespace App\Livewire\Relatorios;

use App\Models\User;
use App\Traits\Toastify;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

class RecorrenciaVisitas extends Component
{
    use Toastify;

    public $data_ini;
    public $data_fim;
    public $meses;
    public $users;
    public $promotor;
    public $recorrencias = [];

    public function mount(){
        $this->data_ini = now()->startOfMonth()->format('Y-m-d');
        $this->data_fim = now()->format('Y-m-d');
        $this->users = User::all();
    }

    public function getRecorrencia()
    {
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
                            FROM visitas v_ant
                            WHERE v_ant.cnpj = v.cnpj
                            AND v_ant.id_user = v.id_user
                            AND v_ant.date BETWEEN DATE_SUB( ?, INTERVAL ? MONTH)
                                                AND DATE_SUB( ?, INTERVAL 1 DAY)
                        ) THEN 'Sim'
                        ELSE 'Não'
                    END AS visitada_ultimos_meses
                FROM visitas v
                JOIN users p ON p.id = v.id_user
                WHERE v.date BETWEEN ? AND ?
                ";

            if(!empty($this->promotor)) {
                $sql .= " AND v.id_user = ?";
            }

            $sql .= " GROUP BY v.cnpj, v.id_user, p.name;";


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
            $this->errorToast('Erro ao buscar recorrência: ' . $e->getMessage());
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
                $this->errorToast(implode(' ', $errors->get('data_ini')));
            }
            if ($errors->has('data_fim')) {
                $this->errorToast(implode(' ', $errors->get('data_fim')));
            }
            if ($errors->has('meses')) {
                $this->errorToast(implode(' ', $errors->get('meses')));
            }

            return;
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.relatorios.recorrencia-visitas');
    }
}
