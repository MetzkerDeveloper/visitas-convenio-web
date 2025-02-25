<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visita extends Model
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

    public function objetivo(): BelongsTo
    {
        return $this->belongsTo(Objetivo::class, 'id_objective');
    }

    public function regiao(): BelongsTo
    {
        return $this->belongsTo(Regiao::class, 'id_region');
    }

    public function promotor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
