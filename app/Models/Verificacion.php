<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Verificacion extends Model
{
    protected $table = 'verificaciones';

    protected $fillable = [
        'embarcacion_id',
        'ip_address',
        'user_agent',
        'resultado',
        'motivos',
    ];

    protected $casts = [
        'motivos' => 'array',
    ];

    public function embarcacion(): BelongsTo
    {
        return $this->belongsTo(Embarcacion::class);
    }
}
