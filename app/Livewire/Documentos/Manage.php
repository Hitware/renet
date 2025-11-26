<?php

namespace App\Livewire\Documentos;

use App\Models\DocumentoEmbarcacion;
use App\Models\Embarcacion;
use Livewire\Component;
use Livewire\WithFileUploads;

class Manage extends Component
{
    use WithFileUploads;

    public $embarcacion;
    public $documentoId;
    public $tipo_documento;
    public $numero_documento;
    public $entidad_emisora;
    public $fecha_expedicion;
    public $fecha_vencimiento;
    public $aseguradora;
    public $monto_asegurado;
    public $pasajeros_cubiertos;
    public $archivo;
    public $observaciones;
    public $showModal = false;
    public $showViewModal = false;
    public $viewingDocument = null;
    public $uploadProgress = 0;
    public $uploadError = false;
    public $showSolicitudModal = false;
    public $documentoSolicitud;
    public $motivoSolicitud = '';

    protected $rules = [
        'tipo_documento' => 'required|in:matricula,certificado_navegacion,poliza_accidentes,poliza_pandi,resolucion_dimar',
        'numero_documento' => 'required|string|max:255',
        'entidad_emisora' => 'required|string|max:255',
        'fecha_expedicion' => 'required|date',
        'fecha_vencimiento' => 'nullable|date|after:fecha_expedicion',
        'aseguradora' => 'nullable|string|max:255',
        'monto_asegurado' => 'nullable|numeric|min:0',
        'pasajeros_cubiertos' => 'nullable|integer|min:0',
        'archivo' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'observaciones' => 'nullable|string',
    ];

    public function mount(Embarcacion $embarcacion)
    {
        $this->embarcacion = $embarcacion->load(['documentos', 'documentos.solicitudesActualizacion' => function($query) {
            $query->where('estado', 'pendiente')->with('inspector');
        }]);
    }

    public function openModal($tipo = null)
    {
        $this->reset(['documentoId', 'tipo_documento', 'numero_documento', 'entidad_emisora', 'fecha_expedicion', 'fecha_vencimiento', 'aseguradora', 'monto_asegurado', 'pasajeros_cubiertos', 'archivo', 'observaciones']);
        $this->tipo_documento = $tipo;
        $this->showModal = true;
    }

    public function edit($documentoId)
    {
        $documento = DocumentoEmbarcacion::findOrFail($documentoId);
        $this->documentoId = $documento->id;
        $this->tipo_documento = $documento->tipo_documento;
        $this->numero_documento = $documento->numero_documento;
        $this->entidad_emisora = $documento->entidad_emisora;
        $this->fecha_expedicion = $documento->fecha_expedicion->format('Y-m-d');
        $this->fecha_vencimiento = $documento->fecha_vencimiento?->format('Y-m-d');
        $this->aseguradora = $documento->aseguradora;
        $this->monto_asegurado = $documento->monto_asegurado;
        $this->pasajeros_cubiertos = $documento->pasajeros_cubiertos;
        $this->observaciones = $documento->observaciones;
        $this->showModal = true;
    }

    protected function rules()
    {
        $rules = [
            'tipo_documento' => 'required|in:matricula,certificado_navegacion,poliza_accidentes,poliza_pandi,resolucion_dimar',
            'numero_documento' => 'required|string|max:255',
            'entidad_emisora' => 'required|string|max:255',
            'fecha_expedicion' => 'required|date',
            'fecha_vencimiento' => 'nullable|date|after:fecha_expedicion',
            'aseguradora' => 'nullable|string|max:255',
            'monto_asegurado' => 'nullable|numeric|min:0',
            'pasajeros_cubiertos' => 'nullable|integer|min:0',
            'observaciones' => 'nullable|string',
        ];

        if (!$this->documentoId) {
            $rules['archivo'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:10240';
        } else {
            $rules['archivo'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240';
        }

        return $rules;
    }

    public function updatedArchivo()
    {
        $this->uploadError = false;
        try {
            $this->validate(['archivo' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240']);
        } catch (\Exception $e) {
            $this->uploadError = true;
            $this->addError('archivo', 'Error al cargar el archivo. Verifique el formato y tamaño.');
        }
    }

    public function save()
    {
        if ($this->uploadError) {
            session()->flash('error', 'Error al cargar el archivo. Por favor, intente nuevamente.');
            return;
        }

        $this->validate();

        if (!$this->documentoId && !$this->archivo) {
            session()->flash('error', 'Debe cargar un archivo para el documento.');
            return;
        }

        $data = [
            'embarcacion_id' => $this->embarcacion->id,
            'tipo_documento' => $this->tipo_documento,
            'numero_documento' => $this->numero_documento,
            'entidad_emisora' => $this->entidad_emisora,
            'fecha_expedicion' => $this->fecha_expedicion,
            'fecha_vencimiento' => $this->fecha_vencimiento,
            'aseguradora' => $this->aseguradora,
            'monto_asegurado' => $this->monto_asegurado,
            'pasajeros_cubiertos' => $this->pasajeros_cubiertos,
            'observaciones' => $this->observaciones,
        ];

        if ($this->archivo) {
            try {
                if (!$this->archivo->isValid()) {
                    throw new \Exception('El archivo no es válido');
                }
                $path = $this->archivo->store('documentos/embarcaciones', 'public');
                if (!$path || !\Storage::disk('public')->exists($path)) {
                    throw new \Exception('No se pudo guardar el archivo');
                }
                $data['archivo_path'] = $path;
            } catch (\Exception $e) {
                session()->flash('error', 'Error al guardar el archivo: ' . $e->getMessage());
                return;
            }
        }

        if ($this->documentoId) {
            $documento = DocumentoEmbarcacion::findOrFail($this->documentoId);
            $documento->update($data);
            $documento->actualizarEstado();
            session()->flash('message', 'Documento actualizado exitosamente.');
        } else {
            $documento = DocumentoEmbarcacion::create($data);
            $documento->actualizarEstado();
            session()->flash('message', 'Documento creado exitosamente.');
        }

        $this->showModal = false;
        $this->embarcacion->refresh();
    }

    public function delete($documentoId)
    {
        $documento = DocumentoEmbarcacion::findOrFail($documentoId);
        $documento->motivo_reemplazo = 'Eliminado manualmente';
        $documento->save();
        $documento->delete();
        session()->flash('message', 'Documento eliminado exitosamente.');
        $this->embarcacion->refresh();
    }

    public function viewDocument($documentoId)
    {
        $this->viewingDocument = DocumentoEmbarcacion::findOrFail($documentoId);
        $this->showViewModal = true;
    }

    public function solicitarActualizacion($documentoId)
    {
        $this->documentoSolicitud = $documentoId;
        $this->motivoSolicitud = '';
        $this->showSolicitudModal = true;
    }

    public function enviarSolicitud()
    {
        $this->validate([
            'motivoSolicitud' => 'required|string|min:10'
        ]);

        \App\Models\SolicitudActualizacion::create([
            'documento_id' => $this->documentoSolicitud,
            'inspector_id' => auth()->id(),
            'motivo' => $this->motivoSolicitud,
            'estado' => 'pendiente'
        ]);

        $this->showSolicitudModal = false;
        session()->flash('message', 'Solicitud de actualización enviada exitosamente.');
        $this->embarcacion->refresh();
    }

    public function marcarSolicitudAtendida($solicitudId)
    {
        $solicitud = \App\Models\SolicitudActualizacion::findOrFail($solicitudId);
        $solicitud->update(['estado' => 'atendida']);
        session()->flash('message', 'Solicitud marcada como atendida.');
        $this->embarcacion->refresh();
    }

    public function render()
    {
        return view('livewire.documentos.manage')->layout('layouts.app');
    }
}
