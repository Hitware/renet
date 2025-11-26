<?php

namespace App\Livewire\Embarcaciones;

use App\Models\Embarcacion;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $estadoFilter = '';
    public $tipoFilter = '';
    public $embarcacionEstado;
    public $nuevoEstado;
    public $showEstadoModal = false;

    protected $queryString = ['search', 'estadoFilter', 'tipoFilter'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function cambiarEstado($embarcacionId, $nuevoEstado)
    {
        $embarcacion = Embarcacion::findOrFail($embarcacionId);
        $embarcacion->update(['estado' => $nuevoEstado]);
        session()->flash('message', 'Estado actualizado exitosamente.');
    }

    public function render()
    {
        $query = Embarcacion::with('empresa')
            ->when(auth()->user()->role === 'empresa', function($q) {
                $q->where('empresa_id', auth()->user()->empresa_id);
            });

        if ($this->search) {
            $query->where(function($q) {
                $q->where('nombre', 'like', '%' . $this->search . '%')
                  ->orWhere('matricula', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->estadoFilter) {
            $query->where('estado', $this->estadoFilter);
        }

        if ($this->tipoFilter) {
            $query->where('tipo', $this->tipoFilter);
        }

        $embarcaciones = $query->latest()->paginate(10);

        return view('livewire.embarcaciones.index', [
            'embarcaciones' => $embarcaciones
        ])->layout('layouts.app');
    }
}
