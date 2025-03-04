<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Validation\Rules;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function rules()
    {
        return [
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ];
    }

    // Caso o User pertença a uma Regiao (chave estrangeira no User)
    public function regiao(): BelongsTo
    {
        return $this->belongsTo(Regiao::class, 'id_region');
    }

    public function nivel(): BelongsTo
    {
        return $this->belongsTo(Nivel::class, 'nivel_acesso');
    }

    public function visita(): HasMany
    {
        return $this->hasMany(Visita::class, 'id_user');
    }

    public function agenda(): HasMany
    {
        return $this->hasMany(Agenda::class, 'id_user');
    }
}
