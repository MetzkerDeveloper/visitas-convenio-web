<?php

namespace App\Livewire\Dashboards;

use App\Models\Agenda;
use App\Models\Visita;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class DashboardKpis extends Component
{
    public string $periodo = 'mes';
    public ?int $promotor = null;

    public ?int $visitasHoje = null;
    public ?string $tempoMedioVisita = null;

    #[On('dashboard:filtersUpdated')]
    public function atualizarFiltros($periodo, $promotor)
    {
        $this->periodo = $periodo;
        $this->promotor = $promotor;
    }

    private function baseQuery()
    {
        $query = Visita::query();

        if ($this->promotor) {
            $query->where('id_user', $this->promotor);
        }

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

        return $query;
    }

    #[Computed]
    public function getVisitasHoje(): ?int
    {
        return $this->baseQuery()->count();
    }

    #[Computed]
    public function getTempoMedioVisita(): ?string
    {
        $query = $this->baseQuery()
            ->whereNotNull('start_time')
            ->whereNotNull('end_time');

        if (DB::getDriverName() === 'sqlite') {
            $query->selectRaw("
                AVG((julianday(end_time) - julianday(start_time)) * 1440) as media
            ");
        } else {
            $query->selectRaw("
                AVG((TIME_TO_SEC(end_time) - TIME_TO_SEC(start_time)) / 60) as media
            ");
        }

        $media = $query->value('media');

        if (!$media) return null;

        return round($media) . ' min';
    }

    #[Computed]
    public function getPercentualVisitasDiaAnterior(): ?string
    {
        $hoje = $this->baseQuery()->count();

        $ontemQuery = Visita::query();

        if ($this->promotor) {
            $ontemQuery->where('id_user', $this->promotor);
        }

        $ontem = $ontemQuery
            ->whereDate('date', today()->subDay())
            ->count();

        if ($ontem === 0) {
            return null;
        }

        $percentual = (($hoje - $ontem) / $ontem) * 100;
        $percentual = round($percentual, 2);

        $sinal = $percentual > 0 ? '+' : '';

        return $sinal . $percentual . '%';
    }

    #[Computed]
    public function getMediaVisitas(): ?string
    {
        $query = $this->baseQuery();

        $totalVisitas = $query->count();

        switch ($this->periodo) {

            case 'hoje':
                $dias = 1;
                break;

            case 'semana':
                $dias = now()->startOfWeek()->diffInDays(now()) + 1;
                break;

            case 'mesAnt':
                $dias = now()->subMonth()->startOfMonth()->diffInDays(now()->subMonth()->endOfMonth()) + 1;
                break;

            case 'mes':
            default:
                $dias = now()->startOfMonth()->diffInDays(now()) + 1;
                break;
        }

        if ($dias === 0) {
            return null;
        }

        $media = $totalVisitas / $dias;

        return number_format($media, 1) . ' visitas/dia';
    }

    #[Computed]
    public function getPercentualPlanejamento(): ?string
    {
        $agendaQuery = Agenda::query();
        $visitaQuery = Visita::query();

        // Filtro por promotor
        if ($this->promotor) {
            $agendaQuery->where('id_user', $this->promotor);
            $visitaQuery->where('id_user', $this->promotor);
        }

        // Filtro por período
        switch ($this->periodo) {
            case 'hoje':
                $agendaQuery->whereDate('date', today());
                $visitaQuery->whereDate('date', today());
                break;

            case 'semana':
                $agendaQuery->whereBetween('date', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ]);
                $visitaQuery->whereBetween('date', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ]);
                break;

            case 'mesAnt':
                $agendaQuery->whereBetween('date', [
                    now()->subMonth()->startOfMonth(),
                    now()->subMonth()->endOfMonth()
                ]);
                $visitaQuery->whereBetween('date', [
                    now()->subMonth()->startOfMonth(),
                    now()->subMonth()->endOfMonth()
                ]);
                break;

            case 'mes':
            default:
                $agendaQuery->whereBetween('date', [
                    now()->startOfMonth(),
                    now()->endOfMonth()
                ]);
                $visitaQuery->whereBetween('date', [
                    now()->startOfMonth(),
                    now()->endOfMonth()
                ]);
                break;
        }

        // Cidades planejadas
        $cidadesPlanejadas = $agendaQuery
        ->pluck('city')
        ->map(fn ($city) => strtolower(trim($city)))
        ->unique();

        $totalPlanejado = $cidadesPlanejadas->count();

        if ($totalPlanejado === 0) {
            return null;
        }

        // Cidades visitadas
        $cidadesVisitadas = $visitaQuery
        ->pluck('city')
        ->map(fn ($city) => strtolower(trim($city)))
        ->unique();

        $totalCumprido = $cidadesPlanejadas
            ->intersect($cidadesVisitadas)
            ->count();

        $percentual = ($totalCumprido / $totalPlanejado) * 100;

        return round($percentual) . '%';
    }

    public function render()
    {
        return view('livewire.dashboards.dashboard-kpis');
    }
}
