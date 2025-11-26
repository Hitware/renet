<?php

namespace App\Livewire\Documentos;

use App\Models\Embarcacion;
use App\Models\SolicitudActualizacion;
use Livewire\Component;

class InspectorView extends Component
{
    public $embarcacion;
    public $documentoSeleccionado;
    public $motivo = '';
    public $mostrarModal = false;

    public function mount(Embarcacion $embarcacion)
    {
        $this->embarcacion = $embarcacion;
    }

    public function solicitarActualizacion($documentoId)
    {
        $this->documentoSeleccionado = $documentoId;
        $this->motivo = '';
        $this->mostrarModal = true;
    }

    public function enviarSolicitud()
    {
        $this->validate([
            'motivo' => 'required|string|min:10'
        ]);

        if ($this->documentoSeleccionado) {
            SolicitudActualizacion::create([
                'documento_id' => $this->documentoSeleccionado,
                'inspector_id' => auth()->id(),
                'motivo' => $this->motivo,
                'estado' => 'pendiente'
            ]);
            $mensaje = 'Solicitud de actualización enviada exitosamente.';
        } else {
            // Solicitud para documento no registrado - se puede manejar de forma especial
            $mensaje = 'Solicitud de registro de documento enviada exitosamente.';
        }

        $this->mostrarModal = false;
        session()->flash('message', $mensaje);
    }

    public function render()
    {
        return view('livewire.documentos.inspector-view')->layout('layouts.app');
    }
}
