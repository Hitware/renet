<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmbarcacionImagen extends Model
{
    protected $table = 'embarcacion_imagenes';

    protected $fillable = [
        'embarcacion_id',
        'ruta',
        'lado',
        'descripcion',
        'es_principal',
        'orden',
    ];

    protected $casts = [
        'es_principal' => 'boolean',
        'orden' => 'integer',
    ];

    public function embarcacion(): BelongsTo
    {
        return $this->belongsTo(Embarcacion::class);
    }
}
