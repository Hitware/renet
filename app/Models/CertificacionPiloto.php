<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class CertificacionPiloto extends Model
{
    protected $table = 'certificaciones_piloto';

    protected $fillable = [
        'piloto_id',
        'tipo_certificacion',
        'numero_certificado',
        'institucion_emisora',
        'fecha_expedicion',
        'fecha_vencimiento',
        'documento_ruta',
    ];

    protected $casts = [
        'fecha_expedicion' => 'date',
        'fecha_vencimiento' => 'date',
    ];

    public function piloto(): BelongsTo
    {
        return $this->belongsTo(Piloto::class);
    }

    public function estaVigente(): bool
    {
        return $this->fecha_vencimiento >= Carbon::today();
    }
}
