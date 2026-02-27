<?php

namespace App\Livewire\Regioes;

use App\Models\Regiao;
use Illuminate\Database\Eloquent\Builder;
use Livewire\{Component, WithPagination};
use Livewire\Attributes\Computed;
use TallStackUi\Traits\Interactions;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\On;

class Index extends Component
{
    use WithPagination;
    use Interactions;

    protected $paginationTheme = 'tailwind';

    protected $queryString = []; // impede ?page=

    public bool $show = false;
    public $regioes;
    public ?int $quantity = 5;
    public ?string $search = null;

    public $headers = [
        ['index' => 'id', 'label' => '#'],
        ['index' => 'name', 'label' => 'Região'],
        ['index' => 'action', 'label' => 'Ações'],
    ];


    #[Computed]
    public function rows(): LengthAwarePaginator
    {
        return Regiao::query()
            ->when($this->search, function (Builder $query) {
                $this->resetPage();
                return $query->where('name', 'like', "%{$this->search}%");
            })
            ->paginate($this->quantity)
            ->withQueryString();
    }

    #[On('refresh::regioes')]
    public function render()
    {
        return view('livewire.regioes.index');
    }
}
