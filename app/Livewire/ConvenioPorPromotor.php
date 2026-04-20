<?php

namespace App\Livewire;

use App\Models\ConveniosPromotor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use TallStackUi\Traits\Interactions;

class ConvenioPorPromotor extends Component
{
    use WithPagination;
    use WithFileUploads;
    use Interactions;

    public $isMobile = true;
    public $files = [];
    public $backup = [];
    public $slide = false;
    public bool $show = false;
    public ?int $quantity = 5;
    public ?string $search = null;
    public ?array $promotores = [];

    public $headers = [
        ['index' => 'id', 'label' => '#'],
        ['index' => 'id_promotor', 'label' => 'Promotor Responsável'],
        ['index' => 'cd_conv', 'label' => 'Código Convênio'],
        ['index' => 'cnpj_conv', 'label' => 'CNPJ Convênio'],
        ['index' => 'nm_conv', 'label' => 'Nome Convênio'],
        ['index' => 'reg_conv', 'label' => 'Região Convênio'],
        ['index' => 'end_conv', 'label' => 'Endereço Convênio'],
        ['index' => 'cidade_conv', 'label' => 'Cidade Convênio'],
        ['index' => 'status_visita', 'label' => 'Visita Realizada'],
        ['index' => 'action', 'label' => 'Ações'],
    ];

    public function mount(): void
    {
        foreach ($this->rows as $row) {
            $this->promotores[$row->id] = (string) $row->id_promotor;
        }
    }

    #[Computed]
    public function rows(): LengthAwarePaginator
    {
        return ConveniosPromotor::query()
          ->with('promotor')
          ->when($this->search, function (Builder $query) {
              $this->resetPage();

              $query->where(function (Builder $query) {
                  $query->whereAny(['nm_conv', 'cd_conv', 'cidade_conv', 'reg_conv'], 'like', "%{$this->search}%")
                      ->orWhereHas('promotor', function (Builder $query) {
                          $query->where('name', 'like', "%{$this->search}%");
                      });
              });
          })
          ->paginate($this->quantity)
          ->withQueryString();
    }


    public function updatingFile(): void
    {
        if (!$this->files) {
            return;
        }

        $this->backup = $this->files;

        $file = Arr::flatten(array_merge($this->backup, [$this->file]));

        $this->files = collect($file)->unique(fn (UploadedFile $item) => $item->getClientOriginalName())->toArray();

    }

    public function updatedPromotores($value, $key): void
    {
        $convenio = ConveniosPromotor::query()->find($key);

        if ($convenio) {
            $convenio->id_promotor = $value;
            $convenio->save();
            $this->dialog()->success('Sucesso', 'Promotor atualizado com sucesso!')->send();
        } else {
            $this->dialog()->error('Erro', 'Não foi possível localizar o convênio!')->send();
        }
    }

    public function importar()
    {
        try {
            $this->validate([
            'files' => 'required|array',
            'files.*' => 'file|mimes:xlsx,xls,csv,ods|max:2048',
        ]);

            $this->slide = false;

            foreach ($this->files as $file) {

                $rows = Excel::toCollection(null, $file)->first();

                $rows->shift();

                foreach ($rows as $row) {

                    $registro = ConveniosPromotor::query()
                    ->where('cd_conv', $row[1])
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->first();

                    if ($registro) {
                        $registro->update([
                            'id_promotor'   => $row[0],
                            'cnpj_conv'     => $row[2],
                            'nm_conv'       => $row[3],
                            'reg_conv'      => $row[4],
                            'end_conv'      => $row[5],
                            'cidade_conv'   => $row[6],
                            'status_visita'  => false,
                        ]);
                    } else {
                        ConveniosPromotor::query()->create([
                            'id_promotor'   => $row[0],
                            'cd_conv'       => $row[1],
                            'cnpj_conv'     => $row[2],
                            'nm_conv'       => $row[3],
                            'reg_conv'      => $row[4],
                            'end_conv'      => $row[5],
                            'cidade_conv'   => $row[6],
                        ]);
                    }

                }

            }

            $this->files = [];
            $this->backup = [];

            $this->dialog()->success('Sucesso', 'Convênios por promotor importados com sucesso!')->send();

            return $this->redirectRoute('visitar');

        } catch (\Exception $e) {
            $this->dialog()->error('Erro', 'Ocorreu um erro ao importar os convênios por promotor: ' . $e->getMessage())->send();
        }
    }

    public function verificarVisitas()
    {
        $convenios = ConveniosPromotor::query()->with('promotor')->where('status_visita', false)->get();
        $convenio_atualizados = 0;
        $convenios_para_atualizar = 0;

        foreach ($convenios as $convenio) {
            $convenio->status_visita = $convenio->visitas()->exists() ? true : false;

            if (isset($convenio->status_visita) && $convenio->status_visita === true) {
                $convenio->save();
                $convenio_atualizados++;
            } else {
                $convenios_para_atualizar++;
            }

        }

        if ($convenio_atualizados > 0) {
            $this->dialog()->success('Sucesso', "Status de visitas atualizado para {$convenio_atualizados} convênio(s)!")->send();
        } else {
            $this->dialog()->info('Informação', "Nenhum convênio atualizado. Existe {$convenios_para_atualizar} convênio(s) sem visita(s) realizada(s).")->send();
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.convenio-por-promotor');
    }
}
