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
        'distintivo_llamada',
        'mmsi',
        'tipo',
        'capacidad_pasajeros',
        'eslora',
        'manga',
        'puntal',
        'calado',
        'tonelaje',
        'ano_construccion',
        'material_casco',
        'motor_marca',
        'motor_modelo',
        'motor_potencia',
        'numero_motores',
        'codigo_qr',
        'numero_omi',
        'estado',
        'observaciones',
        'armador_direccion',
        'armador_email',
        'armador_contacto',
        'armador_telefono',
        'ultima_verificacion',
    ];

    protected $casts = [
        'capacidad_pasajeros' => 'integer',
        'eslora' => 'decimal:2',
        'manga' => 'decimal:2',
        'puntal' => 'decimal:2',
        'calado' => 'decimal:2',
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
     * Get the documentos for the embarcacion.
     */
    public function documentos()
    {
        return $this->hasMany(DocumentoEmbarcacion::class);
    }

    /**
     * Get the imagenes for the embarcacion.
     */
    public function imagenes()
    {
        return $this->hasMany(EmbarcacionImagen::class)->orderBy('orden');
    }

    /**
     * Get the principal image.
     */
    public function imagenPrincipal()
    {
        return $this->hasOne(EmbarcacionImagen::class)->where('es_principal', true);
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

    /**
     * Get the route key for the model.
     */
    public function getRouteKey()
    {
        return encrypt($this->id);
    }

    /**
     * Retrieve the model for a bound value.
     */
    public function resolveRouteBinding($value, $field = null)
    {
        try {
            $id = decrypt($value);
            return $this->where('id', $id)->firstOrFail();
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Check if embarcacion is apta para navegar based on documents.
     */
    public function esAptaParaNavegar(): bool
    {
        return $this->puedeNavegar();
    }

    /**
     * Check if embarcacion can navigate based on documents.
     */
    public function puedeNavegar(): bool
    {
        $tiposRequeridos = ['matricula', 'certificado_navegacion', 'resolucion_dimar'];

        foreach ($tiposRequeridos as $tipo) {
            $documento = $this->documentos()->where('tipo_documento', $tipo)->first();
            if (!$documento || !$documento->estaVigente()) {
                return false;
            }
        }

        // Verificar pólizas: debe tener PANDI O Accidentes (PANDI incluye accidentes)
        $polizaPandi = $this->documentos()->where('tipo_documento', 'poliza_pandi')->first();
        $polizaAccidentes = $this->documentos()->where('tipo_documento', 'poliza_accidentes')->first();
        
        $tienePandiVigente = $polizaPandi && $polizaPandi->estaVigente();
        $tieneAccidentesVigente = $polizaAccidentes && $polizaAccidentes->estaVigente();
        
        if (!$tienePandiVigente && !$tieneAccidentesVigente) {
            return false;
        }

        return true;
    }

    /**
     * Get list of missing or expired documents.
     */
    public function getDocumentosFaltantes(): array
    {
        $tiposRequeridos = [
            'matricula' => 'Matrícula',
            'certificado_navegacion' => 'Certificado de Navegación',
            'resolucion_dimar' => 'Resolución DIMAR'
        ];

        $faltantes = [];

        foreach ($tiposRequeridos as $tipo => $nombre) {
            $documento = $this->documentos()->where('tipo_documento', $tipo)->first();
            if (!$documento) {
                $faltantes[] = "$nombre no registrada";
            } elseif (!$documento->estaVigente()) {
                $faltantes[] = "$nombre vencida";
            }
        }

        // Verificar pólizas: debe tener PANDI O Accidentes
        $polizaPandi = $this->documentos()->where('tipo_documento', 'poliza_pandi')->first();
        $polizaAccidentes = $this->documentos()->where('tipo_documento', 'poliza_accidentes')->first();
        
        $tienePandिVigente = $polizaPandi && $polizaPandi->estaVigente();
        $tieneAccidentesVigente = $polizaAccidentes && $polizaAccidentes->estaVigente();
        
        if (!$tienePandिVigente && !$tieneAccidentesVigente) {
            if (!$polizaPandi && !$polizaAccidentes) {
                $faltantes[] = 'Póliza PANDI o Póliza de Accidentes Personales no registrada';
            } else {
                $faltantes[] = 'Póliza PANDI o Póliza de Accidentes Personales vencida';
            }
        }

        return $faltantes;
    }

    /**
     * Get reasons why embarcacion is not apta para navegar.
     */
    public function getRazonesNoApta(): array
    {
        return $this->getDocumentosFaltantes();
    }
}
