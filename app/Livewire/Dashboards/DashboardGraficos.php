<?php

namespace App\Livewire\Dashboards;

use App\Models\Regiao;
use App\Models\Visita;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
        $prefix = DB::getTablePrefix();
        
        $query = Regiao::from('regiaos as r')
            ->leftJoin('visitas as v', function ($join) {

                $join->on('r.id', '=', 'v.id_region');

                // Filtro por promotor
                if ($this->promotor) {
                    $join->where('v.id_user', $this->promotor);
                }

                // Filtro por período
                switch ($this->periodo) {
                    case 'hoje':
                        $join->whereDate('v.date', today());
                        break;

                    case 'semana':
                        $join->whereBetween('v.date', [
                            now()->startOfWeek(),
                            now()->endOfWeek()
                        ]);
                        break;

                    case 'mesAnt':
                        $join->whereBetween('v.date', [
                            Carbon::now()->subMonth()->startOfMonth(),
                            Carbon::now()->subMonth()->endOfMonth()
                        ]);
                        break;

                    case 'mes':
                    default:
                        $join->whereBetween('v.date', [
                            now()->startOfMonth(),
                            now()->endOfMonth()
                        ]);
                        break;
                }
            })
            ->selectRaw("{$prefix}r.name as regiao, COUNT({$prefix}v.id) as total")
            ->groupBy('r.id', 'r.name')
            ->orderBy('r.name');

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
