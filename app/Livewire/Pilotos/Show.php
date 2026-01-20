<?php

namespace App\Livewire\Pilotos;

use App\Models\Piloto;
use App\Models\CertificacionPiloto;
use App\Models\HistorialNavegacion;
use Livewire\Component;
use Livewire\WithFileUploads;

class Show extends Component
{
    use WithFileUploads;

    public Piloto $piloto;
    
    // Certificación
    public $showCertificacionModal = false;
    public $certificacionId;
    public $tipo_certificacion;
    public $numero_certificado;
    public $institucion_emisora;
    public $fecha_expedicion_cert;
    public $fecha_vencimiento_cert;
    public $documento_cert;

    // Historial
    public $showHistorialModal = false;
    public $historialId;
    public $embarcacion_id;
    public $fecha_inicio;
    public $fecha_fin;
    public $cargo;
    public $observaciones;

    public function mount(Piloto $piloto = null)
    {
        // Solo puede ver su propio perfil
        if (!auth()->user()->piloto) {
            return redirect()->route('pilotos.crear');
        }

        $this->piloto = auth()->user()->piloto;
    }

    public function openCertificacionModal($id = null)
    {
        $this->resetCertificacionForm();
        
        if ($id) {
            $cert = CertificacionPiloto::findOrFail($id);
            $this->certificacionId = $cert->id;
            $this->tipo_certificacion = $cert->tipo_certificacion;
            $this->numero_certificado = $cert->numero_certificado;
            $this->institucion_emisora = $cert->institucion_emisora;
            $this->fecha_expedicion_cert = $cert->fecha_expedicion->format('Y-m-d');
            $this->fecha_vencimiento_cert = $cert->fecha_vencimiento->format('Y-m-d');
        }
        
        $this->showCertificacionModal = true;
    }

    public function saveCertificacion()
    {
        $this->validate([
            'tipo_certificacion' => 'required|string|max:255',
            'numero_certificado' => 'nullable|string|max:100',
            'institucion_emisora' => 'required|string|max:255',
            'fecha_expedicion_cert' => 'required|date',
            'fecha_vencimiento_cert' => 'required|date|after:fecha_expedicion_cert',
            'documento_cert' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $data = [
            'piloto_id' => $this->piloto->id,
            'tipo_certificacion' => $this->tipo_certificacion,
            'numero_certificado' => $this->numero_certificado,
            'institucion_emisora' => $this->institucion_emisora,
            'fecha_expedicion' => $this->fecha_expedicion_cert,
            'fecha_vencimiento' => $this->fecha_vencimiento_cert,
        ];

        if ($this->documento_cert) {
            $data['documento_ruta'] = $this->documento_cert->store('pilotos/certificaciones', 'public');
        }

        if ($this->certificacionId) {
            CertificacionPiloto::findOrFail($this->certificacionId)->update($data);
            session()->flash('message', 'Certificación actualizada.');
        } else {
            CertificacionPiloto::create($data);
            session()->flash('message', 'Certificación agregada.');
        }

        $this->showCertificacionModal = false;
        $this->piloto->refresh();
    }

    public function deleteCertificacion($id)
    {
        $cert = CertificacionPiloto::findOrFail($id);
        if ($cert->documento_ruta) {
            \Storage::disk('public')->delete($cert->documento_ruta);
        }
        $cert->delete();
        session()->flash('message', 'Certificación eliminada.');
        $this->piloto->refresh();
    }

    public function openHistorialModal($id = null)
    {
        $this->resetHistorialForm();
        
        if ($id) {
            $hist = HistorialNavegacion::findOrFail($id);
            $this->historialId = $hist->id;
            $this->embarcacion_id = $hist->embarcacion_id;
            $this->fecha_inicio = $hist->fecha_inicio->format('Y-m-d');
            $this->fecha_fin = $hist->fecha_fin ? $hist->fecha_fin->format('Y-m-d') : null;
            $this->cargo = $hist->cargo;
            $this->observaciones = $hist->observaciones;
        }
        
        $this->showHistorialModal = true;
    }

    public function saveHistorial()
    {
        $this->validate([
            'embarcacion_id' => 'required|exists:embarcaciones,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after:fecha_inicio',
            'cargo' => 'required|string|max:255',
            'observaciones' => 'nullable|string|max:1000',
        ]);

        $data = [
            'piloto_id' => $this->piloto->id,
            'embarcacion_id' => $this->embarcacion_id,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'cargo' => $this->cargo,
            'observaciones' => $this->observaciones,
        ];

        if ($this->historialId) {
            HistorialNavegacion::findOrFail($this->historialId)->update($data);
            session()->flash('message', 'Historial actualizado.');
        } else {
            HistorialNavegacion::create($data);
            session()->flash('message', 'Historial agregado.');
        }

        $this->showHistorialModal = false;
        $this->piloto->refresh();
    }

    public function deleteHistorial($id)
    {
        HistorialNavegacion::findOrFail($id)->delete();
        session()->flash('message', 'Historial eliminado.');
        $this->piloto->refresh();
    }

    private function resetCertificacionForm()
    {
        $this->certificacionId = null;
        $this->tipo_certificacion = '';
        $this->numero_certificado = '';
        $this->institucion_emisora = '';
        $this->fecha_expedicion_cert = '';
        $this->fecha_vencimiento_cert = '';
        $this->documento_cert = null;
    }

    private function resetHistorialForm()
    {
        $this->historialId = null;
        $this->embarcacion_id = '';
        $this->fecha_inicio = '';
        $this->fecha_fin = '';
        $this->cargo = '';
        $this->observaciones = '';
    }

    public function render()
    {
        $embarcaciones = auth()->user()->empresa->embarcaciones;
        
        return view('livewire.pilotos.show', [
            'embarcaciones' => $embarcaciones
        ])->layout('layouts.app');
    }
}
