<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CadastroUsuarioForm extends Form
{
    #[Validate(['required'], 
    message: [
        'nivel_acesso.required' => 'O :attribute é obrigatório.',

    ], 
    attribute: [
        'nivel_acesso.*' => 'nivel de acesso',
    ])]
    public $nivel_acesso;

    #[Validate(['required'], 
    message: [
        'id_region.required' => 'O :attribute é obrigatório.'
    ], 
    attribute:[
        'id_region.*' => 'região',
    ])]
    public $id_region;

    #[Validate(['required', 'string','min:3', 'max:255'], 
    message: [
        'name.required' => 'O :attribute é obrigatório.',
        'name.string' => 'O :attribute deve ser um texto.',
        'name.min:3' => 'O :attribute deve ter pelo menos 3 caracteres.',

    ], 
    attribute: [
        'name.*' => 'nome',
    ])]
    public $name;

    #[Validate([
        'required',
        'string',
        'lowercase',
        'email',
        'max:255',
        'unique:' . User::class,
        'regex:/^[a-zA-Z0-9._%+-]+@farmaciaindiana\.com\.br$/'
    ], 
    message: [
        'email.required' => 'O :attribute é obrigatório.',
        'email.string' => 'O :attribute deve ser um texto.',
        'email.lowercase' => 'O :attribute deve ser em letras minúsculas.',
        'email.email' => 'O :attribute deve ser um e-mail válido.',
        'email.max:255' => 'O :attribute deve ter no máximo 255 caracteres.',
        'email.unique' => 'O :attribute já está em uso.',   
        'email.regex' => 'O :attribute deve ser um e-mail válido da Farmácia Indiana.'

    ], 
    attribute: [
        'email.*' => 'e-mail',
    ])]
    public $email = '@farmaciaindiana.com.br';


    #[Validate(['required', 'string', 'confirmed'], 
    message: [
        'password.required' => 'A :attribute é obrigatória.',
        'password.string' => 'A :attribute deve ser um texto.',
        'password.confirmed' => 'A :attribute deve ser igual a do campo confirme a senha.',

    ], 
    attribute: [
        'password.*' => 'senha',
    ])]
    public $password;

    public string $password_confirmation = '';

}
