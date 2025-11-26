<?php

namespace App\Livewire\Documentos;

use App\Models\Embarcacion;
use App\Models\DocumentoEmbarcacion;
use Livewire\Component;

class History extends Component
{
    public $embarcacion;
    public $tipoFiltro = 'todos';
    public $showViewModal = false;
    public $viewingDocument = null;

    public function mount(Embarcacion $embarcacion)
    {
        $this->embarcacion = $embarcacion;
    }

    public function viewDocument($documentoId)
    {
        $this->viewingDocument = DocumentoEmbarcacion::withTrashed()->findOrFail($documentoId);
        $this->showViewModal = true;
    }

    public function render()
    {
        $query = DocumentoEmbarcacion::withTrashed()
            ->where('embarcacion_id', $this->embarcacion->id)
            ->orderBy('created_at', 'desc');

        if ($this->tipoFiltro !== 'todos') {
            $query->where('tipo_documento', $this->tipoFiltro);
        }

        $documentos = $query->get()->groupBy('tipo_documento');

        return view('livewire.documentos.history', [
            'documentos' => $documentos
        ])->layout('layouts.app');
    }
}
