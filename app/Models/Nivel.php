<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Nivel extends Model
{
    public function promotor(): HasOne
    {
        return $this->hasOne(User::class, 'nivel_acesso');
    }
}
