<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class DocumentoEmbarcacion extends Model
{
    use SoftDeletes;

    protected $table = 'documentos_embarcacion';

    protected $fillable = [
        'embarcacion_id',
        'tipo_documento',
        'numero_documento',
        'entidad_emisora',
        'fecha_expedicion',
        'fecha_vencimiento',
        'aseguradora',
        'monto_asegurado',
        'pasajeros_cubiertos',
        'archivo_path',
        'estado',
        'observaciones',
        'motivo_reemplazo',
        'reemplazado_por',
    ];

    protected $casts = [
        'fecha_expedicion' => 'date',
        'fecha_vencimiento' => 'date',
        'monto_asegurado' => 'decimal:2',
        'pasajeros_cubiertos' => 'integer',
    ];

    public function embarcacion(): BelongsTo
    {
        return $this->belongsTo(Embarcacion::class);
    }

    public function solicitudesActualizacion()
    {
        return $this->hasMany(SolicitudActualizacion::class, 'documento_id');
    }

    public function actualizarEstado(): void
    {
        if (!$this->fecha_vencimiento) {
            $this->estado = 'vigente';
            return;
        }

        $hoy = Carbon::now();
        $diasParaVencer = $hoy->diffInDays($this->fecha_vencimiento, false);

        if ($diasParaVencer < 0) {
            $this->estado = 'vencido';
        } elseif ($diasParaVencer <= 30) {
            $this->estado = 'por_vencer';
        } else {
            $this->estado = 'vigente';
        }

        $this->save();
    }

    public function estaVigente(): bool
    {
        if (!$this->fecha_vencimiento) {
            return true;
        }
        return Carbon::now()->lte($this->fecha_vencimiento);
    }

    public function diasParaVencer(): ?int
    {
        if (!$this->fecha_vencimiento) {
            return null;
        }
        return Carbon::now()->diffInDays($this->fecha_vencimiento, false);
    }

    public function scopeVigentes($query)
    {
        return $query->where('estado', 'vigente');
    }

    public function scopeVencidos($query)
    {
        return $query->where('estado', 'vencido');
    }

    public function scopePorVencer($query)
    {
        return $query->where('estado', 'por_vencer');
    }

    public function scopePorTipo($query, string $tipo)
    {
        return $query->where('tipo_documento', $tipo);
    }

    public function getNombreTipoAttribute(): string
    {
        return match($this->tipo_documento) {
            'matricula' => 'Matrícula',
            'certificado_navegacion' => 'Certificado de Navegación',
            'poliza_accidentes' => 'Póliza de Accidentes Personales',
            'poliza_pandi' => 'Póliza Todo Riesgo PANDI',
            'resolucion_dimar' => 'Resolución DIMAR',
            default => 'Documento',
        };
    }

    public function getEstadoColorAttribute(): string
    {
        return match($this->estado) {
            'vigente' => 'green',
            'por_vencer' => 'yellow',
            'vencido' => 'red',
            default => 'gray',
        };
    }
}
