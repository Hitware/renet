<?php

namespace App\Livewire\Pilotos;

use Livewire\Component;

class Index extends Component
{
    public function mount()
    {
        $piloto = auth()->user()->piloto;

        // Si no tiene perfil de piloto, redirigir a crear
        if (!$piloto) {
            return $this->redirect(route('pilotos.crear'), navigate: true);
        }

        // Si ya tiene perfil, redirigir a ver detalle
        return $this->redirect(route('pilotos.show', $piloto), navigate: true);
    }

    public function render()
    {
        return view('livewire.pilotos.index');
    }
}
