<?php

namespace App\Livewire\Pilotos;

use App\Models\Piloto;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public $pilotoId;
    public $nombres;
    public $apellidos;
    public $tipo_documento = 'CC';
    public $numero_documento;
    public $fecha_nacimiento;
    public $telefono;
    public $email;
    public $direccion;
    public $foto_perfil;
    public $foto_actual;
    public $licencia_numero;
    public $licencia_tipo = 'Capitán';
    public $licencia_fecha_expedicion;
    public $licencia_fecha_vencimiento;
    public $anos_experiencia = 0;
    public $estado = 'activo';

    protected function rules()
    {
        $rules = [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'tipo_documento' => 'required|in:CC,CE,PAS',
            'numero_documento' => 'required|string|max:50|unique:pilotos,numero_documento',
            'fecha_nacimiento' => 'required|date|before:today',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:pilotos,email',
            'direccion' => 'required|string|max:500',
            'foto_perfil' => 'nullable|image|max:5120',
            'licencia_numero' => 'required|string|max:100|unique:pilotos,licencia_numero',
            'licencia_tipo' => 'required|in:Capitán,Patrón,Marinero,Otro',
            'licencia_fecha_expedicion' => 'required|date',
            'licencia_fecha_vencimiento' => 'required|date|after:licencia_fecha_expedicion',
            'anos_experiencia' => 'required|integer|min:0|max:50',
            'estado' => 'required|in:activo,inactivo,suspendido',
        ];

        if ($this->pilotoId) {
            $rules['numero_documento'] = 'required|string|max:50|unique:pilotos,numero_documento,' . $this->pilotoId;
            $rules['email'] = 'required|email|max:255|unique:pilotos,email,' . $this->pilotoId;
            $rules['licencia_numero'] = 'required|string|max:100|unique:pilotos,licencia_numero,' . $this->pilotoId;
        }

        return $rules;
    }

    public function mount(Piloto $piloto = null)
    {
        // Si el usuario ya tiene un perfil de piloto, cargar sus datos
        if (auth()->user()->piloto) {
            $piloto = auth()->user()->piloto;
            $this->pilotoId = $piloto->id;
            $this->fill($piloto->toArray());
            $this->foto_actual = $piloto->foto_perfil;
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'empresa_id' => auth()->user()->empresa_id,
            'nombres' => trim(strip_tags($this->nombres)),
            'apellidos' => trim(strip_tags($this->apellidos)),
            'tipo_documento' => $this->tipo_documento,
            'numero_documento' => trim(strip_tags($this->numero_documento)),
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'telefono' => trim(strip_tags($this->telefono)),
            'email' => trim(strip_tags($this->email)),
            'direccion' => trim(strip_tags($this->direccion)),
            'licencia_numero' => trim(strip_tags($this->licencia_numero)),
            'licencia_tipo' => $this->licencia_tipo,
            'licencia_fecha_expedicion' => $this->licencia_fecha_expedicion,
            'licencia_fecha_vencimiento' => $this->licencia_fecha_vencimiento,
            'anos_experiencia' => (int)$this->anos_experiencia,
            'estado' => $this->estado,
        ];

        if ($this->foto_perfil) {
            $data['foto_perfil'] = $this->foto_perfil->store('pilotos/fotos', 'public');
            
            // Eliminar foto anterior si existe
            if ($this->foto_actual) {
                \Storage::disk('public')->delete($this->foto_actual);
            }
        }

        if ($this->pilotoId) {
            $piloto = Piloto::findOrFail($this->pilotoId);
            $piloto->update($data);
            session()->flash('message', 'Perfil de piloto actualizado exitosamente.');
        } else {
            $piloto = Piloto::create($data);
            $piloto->generateQrCode();
            
            // Vincular el piloto al usuario
            auth()->user()->update(['piloto_id' => $piloto->id]);
            
            session()->flash('message', 'Perfil de piloto creado exitosamente.');
        }

        return redirect()->route('pilotos.show', $piloto);
    }

    public function render()
    {
        return view('livewire.pilotos.form')->layout('layouts.app');
    }
}
