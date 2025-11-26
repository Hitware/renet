<?php

namespace App\Livewire\Embarcaciones;

use App\Models\Embarcacion;
use App\Models\SolicitudActualizacion;
use Livewire\Component;

class Show extends Component
{
    public $embarcacion;
    public $mostrarModal = false;
    public $documentoSeleccionado;
    public $tipoDocumento;
    public $motivo = '';

    public function mount(Embarcacion $embarcacion)
    {
        $this->embarcacion = $embarcacion->load(['empresa', 'documentos']);

        if (auth()->user()->role === 'empresa' && $this->embarcacion->empresa_id !== auth()->user()->empresa_id) {
            abort(403);
        }
    }

    public function solicitarActualizacion($documentoId, $tipo = null)
    {
        $this->documentoSeleccionado = $documentoId;
        $this->tipoDocumento = $tipo;
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
        }

        $this->mostrarModal = false;
        session()->flash('message', 'Solicitud enviada exitosamente.');
    }

    public function delete()
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'empresa') {
            abort(403);
        }

        $this->embarcacion->delete();
        session()->flash('message', 'Embarcación eliminada exitosamente.');
        return redirect()->route('embarcaciones.index');
    }

    public function render()
    {
        return view('livewire.embarcaciones.show')->layout('layouts.app');
    }
}
