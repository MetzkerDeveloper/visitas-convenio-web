<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{HasMany, HasOne};

class Regiao extends Model
{
    use HasFactory;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function promotor(): HasOne
    {
        return $this->hasOne(User::class, 'id_region');
    }

    public function visita(): HasMany
    {
        return $this->hasMany(Visita::class);
    }
}
