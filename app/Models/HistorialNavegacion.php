<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistorialNavegacion extends Model
{
    protected $table = 'historial_navegacion';

    protected $fillable = [
        'piloto_id',
        'embarcacion_id',
        'fecha_inicio',
        'fecha_fin',
        'cargo',
        'observaciones',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    public function piloto(): BelongsTo
    {
        return $this->belongsTo(Piloto::class);
    }

    public function embarcacion(): BelongsTo
    {
        return $this->belongsTo(Embarcacion::class);
    }

    public function estaActivo(): bool
    {
        return is_null($this->fecha_fin);
    }
}
