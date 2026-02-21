<?php

namespace App\Livewire\Dashboards;

use App\Models\Visita;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class DashboardRanking extends Component
{
    public string $periodo = 'mes';
    public ?int $promotor = null;

    public $ranking;

    public function mount()
    {
        $this->carregarRanking();
    }

    #[On('dashboard:filtersUpdated')]
    public function atualizarFiltros($periodo, $promotor)
    {
        $this->periodo = $periodo;
        $this->promotor = $promotor;

        $this->carregarRanking();
    }

    private function basePeriodo($query)
    {
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

            case 'mes':
            default:
                $query->whereBetween('date', [
                    now()->startOfMonth(),
                    now()->endOfMonth()
                ]);
                break;
        }

        return $query;
    }

    private function carregarRanking()
    {
        $query = Visita::query();

        $this->basePeriodo($query);

        if ($this->promotor) {
            $query->where('id_user', $this->promotor);
        }

        if (DB::getDriverName() === 'sqlite') {

            $this->ranking = $query
                ->whereNotNull('end_time')
                ->selectRaw('
                    id_user,
                    COUNT(*) as total_visitas,
                    SUM((julianday(end_time) - julianday(start_time)) * 1440) as total_minutos
                ')
                ->groupBy('id_user')
                ->with('promotor')
                ->get();

        } else {

            $this->ranking = $query
                ->whereNotNull('end_time')
                ->selectRaw('
                    id_user,
                    COUNT(*) as total_visitas,
                    SUM(TIMESTAMPDIFF(MINUTE, start_time, end_time)) as total_minutos
                ')
                ->groupBy('id_user')
                ->with('promotor')
                ->get();
        }

        // Calcular produtividade
        $this->ranking = $this->ranking->map(function ($item) {

            $horas = $item->total_minutos / 60;

            $produtividade = $horas > 0
                ? round($item->total_visitas / $horas, 2)
                : 0;

            $item->produtividade = $produtividade;

            return $item;
        })
        ->sortByDesc('produtividade')
        ->values();
    }


    public function render()
    {
        return view('livewire.dashboards.dashboard-ranking');
    }
}
