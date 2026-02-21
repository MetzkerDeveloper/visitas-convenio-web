<?php

namespace App\Livewire\Dashboards;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public string $periodo = 'mes';
    public ?int $promotor = null;

    #[On('dashboard:filtersUpdated')]
    public function atualizarFiltros($periodo, $promotor)
    {
        $this->periodo = $periodo;
        $this->promotor = $promotor;
    }

    public function render()
    {
        return view('livewire.dashboards.dashboard');
    }
}
