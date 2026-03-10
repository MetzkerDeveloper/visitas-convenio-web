<?php

namespace App\Livewire\Dashboards;

use App\Models\Regiao;
use App\Models\Visita;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class DashboardGraficos extends Component
{

    public string $periodo = 'mes';
    public ?int $promotor = null;

    public array $labels = [];
    public array $dados = [];

    #[On('dashboard:filtersUpdated')]
    public function atualizarFiltros($periodo, $promotor)
    {
        $this->periodo = $periodo;
        $this->promotor = $promotor;

        $this->carregarDados();
    }

    public function mount()
    {
        $this->carregarDados();
    }
    
    private function carregarDados()
    {
        $query = Regiao::query()
            ->leftJoin('visitas', function ($join) {

                $join->on('regiaos.id', '=', 'visitas.id_region');

                // Filtro por promotor
                if ($this->promotor) {
                    $join->where('visitas.id_user', $this->promotor);
                }

                // Filtro por período
                switch ($this->periodo) {
                    case 'hoje':
                        $join->whereDate('visitas.date', today());
                        break;

                    case 'semana':
                        $join->whereBetween('visitas.date', [
                            now()->startOfWeek(),
                            now()->endOfWeek()
                        ]);
                        break;

                    case 'mesAnt':
                        $join->whereBetween('visitas.date', [
                            Carbon::now()->subMonth()->startOfMonth(),
                            Carbon::now()->subMonth()->endOfMonth()
                        ]);
                        break;

                    case 'mes':
                    default:
                        $join->whereBetween('visitas.date', [
                            now()->startOfMonth(),
                            now()->endOfMonth()
                        ]);
                        break;
                }
            })
            ->selectRaw('regiaos.name as regiao, COUNT(visitas.id) as total')
            ->groupBy('regiaos.id', 'regiaos.name')
            ->orderBy('regiaos.name');

        $dados = $query->get();

        $this->labels = $dados->pluck('regiao')->toArray();
        $this->dados = $dados->pluck('total')->toArray();

        $this->dispatch(
            'graficoAtualizado',
            labels: $this->labels,
            dados: $this->dados
        );
    }

    public function render()
    {
        return view('livewire.dashboards.dashboard-graficos');
    }
}
