<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Piloto extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'empresa_id',
        'nombres',
        'apellidos',
        'tipo_documento',
        'numero_documento',
        'fecha_nacimiento',
        'telefono',
        'email',
        'direccion',
        'foto_perfil',
        'licencia_numero',
        'licencia_tipo',
        'licencia_fecha_expedicion',
        'licencia_fecha_vencimiento',
        'anos_experiencia',
        'estado',
        'codigo_qr',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'licencia_fecha_expedicion' => 'date',
        'licencia_fecha_vencimiento' => 'date',
        'anos_experiencia' => 'integer',
    ];

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function certificaciones(): HasMany
    {
        return $this->hasMany(CertificacionPiloto::class);
    }

    public function historialNavegacion(): HasMany
    {
        return $this->hasMany(HistorialNavegacion::class);
    }

    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombres} {$this->apellidos}";
    }

    public function estaActivo(): bool
    {
        return $this->estado === 'activo';
    }

    public function licenciaVigente(): bool
    {
        return $this->licencia_fecha_vencimiento >= Carbon::today();
    }

    public function getCertificacionesVigentes()
    {
        return $this->certificaciones()->whereDate('fecha_vencimiento', '>=', Carbon::today())->get();
    }

    public function generateQrCode(): string
    {
        if (!$this->codigo_qr) {
            $this->codigo_qr = Str::uuid()->toString();
            $this->save();
        }
        return $this->codigo_qr;
    }

    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    public function scopeConLicenciaVigente($query)
    {
        return $query->whereDate('licencia_fecha_vencimiento', '>=', Carbon::today());
    }

    public function scopePorEmpresa($query, $empresaId)
    {
        return $query->where('empresa_id', $empresaId);
    }

    public function getRouteKey()
    {
        return encrypt($this->id);
    }

    public function resolveRouteBinding($value, $field = null)
    {
        try {
            $id = decrypt($value);
            return $this->where('id', $id)->firstOrFail();
        } catch (\Exception $e) {
            abort(404);
        }
    }
}
