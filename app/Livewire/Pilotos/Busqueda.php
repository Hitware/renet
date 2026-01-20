<?php

namespace App\Livewire\Pilotos;

use App\Models\Piloto;
use Livewire\Component;
use Livewire\WithPagination;

class Busqueda extends Component
{
    use WithPagination;

    public $licencia_tipo = '';
    public $anos_experiencia_min = 0;
    public $estado = '';
    public $buscar = '';

    protected $queryString = [
        'licencia_tipo' => ['except' => ''],
        'anos_experiencia_min' => ['except' => 0],
        'estado' => ['except' => ''],
        'buscar' => ['except' => ''],
    ];

    public function updatingLicenciaTipo()
    {
        $this->resetPage();
    }

    public function updatingAnosExperienciaMin()
    {
        $this->resetPage();
    }

    public function updatingEstado()
    {
        $this->resetPage();
    }

    public function updatingBuscar()
    {
        $this->resetPage();
    }

    public function limpiarFiltros()
    {
        $this->reset(['licencia_tipo', 'anos_experiencia_min', 'estado', 'buscar']);
        $this->resetPage();
    }

    public function render()
    {
        $query = Piloto::with(['empresa', 'certificaciones'])
            ->where('estado', 'activo')
            ->whereDate('licencia_fecha_vencimiento', '>=', now());

        if ($this->licencia_tipo) {
            $query->where('licencia_tipo', $this->licencia_tipo);
        }

        if ($this->anos_experiencia_min > 0) {
            $query->where('anos_experiencia', '>=', $this->anos_experiencia_min);
        }

        if ($this->buscar) {
            $query->where(function ($q) {
                $q->where('nombres', 'like', '%' . $this->buscar . '%')
                  ->orWhere('apellidos', 'like', '%' . $this->buscar . '%')
                  ->orWhere('numero_documento', 'like', '%' . $this->buscar . '%');
            });
        }

        $pilotos = $query->orderBy('anos_experiencia', 'desc')
                        ->paginate(12);

        $tiposLicencia = ['Capitán', 'Patrón', 'Marinero', 'Otro'];

        return view('livewire.pilotos.busqueda', [
            'pilotos' => $pilotos,
            'tiposLicencia' => $tiposLicencia,
        ])->layout('layouts.app');
    }
}
