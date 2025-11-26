<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudActualizacion extends Model
{
    protected $table = 'solicitudes_actualizacion';

    protected $fillable = [
        'documento_id',
        'inspector_id',
        'motivo',
        'estado'
    ];

    public function documento()
    {
        return $this->belongsTo(DocumentoEmbarcacion::class, 'documento_id');
    }

    public function inspector()
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }
}
