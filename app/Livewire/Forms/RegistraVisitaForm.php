<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class RegistraVisitaForm extends Form
{

    
    #[Validate('required')]
    public $id_objective;

    #[Validate('required')]
    public $id_region;

    #[Validate('required')]
    public $date;

    #[Validate('required')]
    public $start_time;

    #[Validate('required')]
    public $end_time;

    #[Validate('required')]
    public $enterprise;

    #[Validate('required')]
    public $cnpj;

    #[Validate('required')]
    public $activity_branch;

    #[Validate('required')]
    public $responsable;

    #[Validate('required')]
    public $company_phone;

    #[Validate('required')]
    public $city;

    #[Validate('required')]
    public $observation;

    public $code_conv;

}
