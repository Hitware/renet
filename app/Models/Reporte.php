<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    protected $fillable = [
        'embarcacion_id',
        'nombre_reportante',
        'email_reportante',
        'telefono_reportante',
        'descripcion',
        'imagen',
        'ip_address',
        'estado'
    ];

    public function embarcacion()
    {
        return $this->belongsTo(Embarcacion::class);
    }
}
