<?php

namespace App\Livewire;

use App\Livewire\Forms\AgendaVisitaForm;
use App\Models\{Agenda as Agenda_de_Visita, User};
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\{Component, WithPagination};
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use TallStackUi\Traits\Interactions;

class Agenda extends Component
{
    use WithPagination;
    use WithFileUploads;
    use Interactions;

    public $files = []; 

    public $backup = [];
    public $slide = false;
    public $isMobile = true;

    public AgendaVisitaForm $form;

    public ?User $user = null;

    public $data_ini = null;

    public $data_fim = null;

    public bool $show = false;

    public function setShow($param): void
    {
        $this->show = $param;
    }

    public function getAgenda()
    {

        $visitas = Agenda_de_Visita::query()->with('promotor')
            ->when(!$this->data_ini && !$this->data_fim, fn (Builder $q) => $q->where('date', 'like', '%' . date('Y-m') . '%'));

        if (Auth::user()->nivel_acesso == 3) {
            $visitas->where('id_user', Auth::user()->id);
        }

        if ($this->data_ini && $this->data_fim) {
            $visitas->whereBetween('date', [$this->data_ini, $this->data_fim]);
        }

        return $visitas->orderBy('date', 'desc')->paginate(6);
    }

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function pesquisar(): void
    {
        $this->getAgenda();
    }

    public function store()
    {

        $this->form->validate();

        // Adiciona o user_id ao array de dados
        $data            = $this->form->all();
        $data['id_user'] = $this->user->id;

        Agenda_de_Visita::create($data);

        return $this->redirectRoute('agenda');
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


    public function importar()
    {
        try{
            $this->validate([
            'files' => 'required|array',
            'files.*' => 'file|mimes:xlsx,xls,csv,ods|max:2048',
        ]);

        $this->slide = false;

        foreach ($this->files as $file) {
        
        $rows = Excel::toCollection(null, $file)->first();

        $rows->shift();
    
        foreach ($rows as $row){

            $data = is_numeric($row[0])
                ? Date::excelToDateTimeObject($row[0])->format('Y-m-d')
                : \Carbon\Carbon::parse($row[0])->format('Y-m-d');
            $cidade = strtoupper($row[1]);
            $obs = strtoupper($row[2]);
            $user_id = Auth::id();

            Agenda_de_Visita::create([
                'date' => $data,
                'city' => $cidade,
                'observation' => $obs,
                'id_user' => $user_id,
            ]);
         }

        }

        $this->files = [];
        $this->backup = [];

        $this->dialog()->success('Sucesso', 'Agenda importada com sucesso!')->send();

        return $this->redirectRoute('agenda');

        }catch (\Exception $e) {
            $this->dialog()->error('Erro', 'Ocorreu um erro ao importar a agenda: ' . $e->getMessage())->send();
        }
    }


    #[Layout('layouts.app')]
    public function render()
    {
        $visitas = $this->getAgenda();

        return view('livewire.agenda', compact('visitas'));
    }
}
