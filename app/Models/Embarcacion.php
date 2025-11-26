<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Embarcacion extends Model
{
    use SoftDeletes;

    protected $table = 'embarcaciones';

    protected $fillable = [
        'empresa_id',
        'matricula',
        'nombre',
        'tipo',
        'capacidad_pasajeros',
        'eslora',
        'manga',
        'tonelaje',
        'ano_construccion',
        'material_casco',
        'motor_marca',
        'motor_modelo',
        'motor_potencia',
        'codigo_qr',
        'estado',
        'observaciones',
        'ultima_verificacion',
    ];

    protected $casts = [
        'capacidad_pasajeros' => 'integer',
        'eslora' => 'decimal:2',
        'manga' => 'decimal:2',
        'tonelaje' => 'decimal:2',
        'motor_potencia' => 'integer',
        'ultima_verificacion' => 'datetime',
    ];

    /**
     * Get the empresa that owns the embarcacion.
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    /**
     * Generate a unique QR code for the embarcacion.
     */
    public function generateQrCode(): string
    {
        if (!$this->codigo_qr) {
            $this->codigo_qr = Str::uuid()->toString();
            $this->save();
        }

        return $this->codigo_qr;
    }

    /**
     * Scope a query to only include available embarcaciones.
     */
    public function scopeDisponible($query)
    {
        return $query->where('estado', 'disponible');
    }

    /**
     * Scope a query to only include embarcaciones by type.
     */
    public function scopeByTipo($query, string $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    /**
     * Check if embarcacion is available.
     */
    public function isDisponible(): bool
    {
        return $this->estado === 'disponible';
    }

    /**
     * Get the status color for display.
     */
    public function getStatusColor(): string
    {
        return match($this->estado) {
            'disponible' => 'green',
            'no_disponible' => 'red',
            'mantenimiento' => 'yellow',
            'suspendida' => 'red',
            default => 'gray',
        };
    }

    /**
     * Get the public URL for QR verification.
     */
    public function getVerificationUrl(): string
    {
        return route('verificar', ['codigo' => $this->codigo_qr]);
    }
}
