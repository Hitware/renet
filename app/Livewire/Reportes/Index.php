<?php

namespace App\Livewire\Reportes;

use App\Models\Reporte;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $estado = '';

    public function cambiarEstado($reporteId, $nuevoEstado)
    {
        $reporte = Reporte::findOrFail($reporteId);
        $reporte->update(['estado' => $nuevoEstado]);
        session()->flash('message', 'Estado actualizado exitosamente.');
    }

    public function render()
    {
        $query = Reporte::with('embarcacion')->latest();

        if ($this->estado) {
            $query->where('estado', $this->estado);
        }

        return view('livewire.reportes.index', [
            'reportes' => $query->paginate(15)
        ])->layout('layouts.app');
    }
}
