<?php

namespace App\Livewire\Dashboards;

use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;

class DashboardFilters extends Component
{

    public string $periodo = 'mes';
    public ?int $promotor = null;

    public function updated()
    {
        $this->dispatch('dashboard:filtersUpdated',
            periodo: $this->periodo,
            promotor: $this->promotor
        );
    }


    public function render()
    {
        return view('livewire.dashboards.dashboard-filters', [
            'promotores' => User::orderBy('name')->get()
        ]);
    }
}
