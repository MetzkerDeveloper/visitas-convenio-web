<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;
use App\Models\User;
use App\Models\Visita;
use Livewire\Attributes\On;

class MapaVisitas extends Component
{

    public string $periodo = 'mes';
    public ?int $promotor = null;

    public $users;
    public $user_id;
    public $data_inicio;
    public $data_fim;

    #[On('dashboard:filtersUpdated')]
    public function atualizarFiltros($periodo, $promotor)
    {
        $this->periodo = $periodo;
        $this->promotor = $promotor;
        $this->buscar();
    }

    public function buscar()
    {

        $query = Visita::query();

        if ($this->promotor) {
            $query->where('id_user', $this->promotor);
        }
        
            // Filtro por período  
        switch ($this->periodo) {
                case 'hoje':
                    $query->whereDate('date', today());
                    break;

                case 'semana':
                    $query->whereBetween('date', [
                        now()->startOfWeek(),
                        now()->endOfWeek()
                    ]);
                    break;

                case 'mesAnt':
                    $query->whereBetween('date', [
                        now()->subMonth()->startOfMonth(),
                        now()->subMonth()->endOfMonth()
                    ]);
                    break;

                case 'mes':
                default:
                    $query->whereBetween('date', [
                        now()->startOfMonth(),
                        now()->endOfMonth()
                    ]);
                    break;
        }
        
        $query->orderBy('created_at');

        $visitas = $query->get()->map(function($v){
                if(!$v->location || !str_contains($v->location, ',')){
                    return null;
                }

                [$lng,$lat] = explode(',', $v->location);

                return [
                    'latitude' => (float)$lat,
                    'longitude' => (float)$lng,
                    'data' => $v->created_at->format('d/m/Y H:i'),
                    'empresa' => $v->enterprise ? $v->enterprise : 'N/A'
                ];

            })
            ->filter()
            ->values();

        $this->dispatch('carregarMapa', visitas: $visitas);

    }

    public function render()
    {
        return view('livewire.dashboards.mapa-visitas');
    }
}
