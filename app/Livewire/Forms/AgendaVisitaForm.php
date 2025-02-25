<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class AgendaVisitaForm extends Form
{

    #[Validate('required')]
    public $city;

    #[Validate('required')]
    public $observation;

    #[Validate('required')]
    public $date;
}
