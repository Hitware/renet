<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nit',
        'razon_social',
        'nombre_comercial',
        'direccion',
        'telefono',
        'email',
        'representante_legal',
        'documento_representante',
        'estado',
        'fecha_autorizacion_dimar',
        'numero_autorizacion_dimar',
        'observaciones',
    ];

    protected $casts = [
        'fecha_autorizacion_dimar' => 'date',
    ];

    /**
     * Get the embarcaciones for the empresa.
     */
    public function embarcaciones(): HasMany
    {
        return $this->hasMany(Embarcacion::class);
    }

    /**
     * Get the users for the empresa.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Scope a query to only include active empresas.
     */
    public function scopeActiva($query)
    {
        return $query->where('estado', 'activa');
    }

    /**
     * Check if empresa is active.
     */
    public function isActiva(): bool
    {
        return $this->estado === 'activa';
    }
}
