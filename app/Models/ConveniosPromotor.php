<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConveniosPromotor extends Model
{
    public function promotor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_promotor');
    }

    public function visitas(): HasMany
    {
        return $this->hasMany(Visita::class, 'cnpj', 'cnpj_conv');
    }
}
