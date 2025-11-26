<?php

namespace App\Livewire\Embarcaciones;

use App\Models\Embarcacion;
use App\Models\Empresa;
use App\Models\EmbarcacionImagen;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public $embarcacionId;
    public $empresa_id;
    public $matricula;
    public $nombre;
    public $tipo = 'motonave_pasaje';
    public $capacidad_pasajeros;
    public $eslora;
    public $manga;
    public $tonelaje;
    public $ano_construccion;
    public $material_casco;
    public $motor_marca;
    public $motor_modelo;
    public $motor_potencia;
    public $observaciones;
    public $imagenes = [];
    public $imagenesExistentes = [];

    protected function rules()
    {
        return [
            'empresa_id' => 'required|exists:empresas,id',
            'matricula' => 'required|string|regex:/^[A-Z0-9\-]+$/|max:50|unique:embarcaciones,matricula',
            'nombre' => 'required|string|regex:/^[a-zA-Z0-9\s\-\.]+$/|max:255',
            'tipo' => 'required|in:motonave_pasaje,carga,pesquera,recreativa',
            'capacidad_pasajeros' => 'nullable|integer|min:1|max:9999',
            'eslora' => 'nullable|numeric|min:0|max:999.99',
            'manga' => 'nullable|numeric|min:0|max:999.99',
            'tonelaje' => 'nullable|numeric|min:0|max:999999.99',
            'ano_construccion' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'material_casco' => 'nullable|string|regex:/^[a-zA-Z0-9\s\-\.]+$/|max:100',
            'motor_marca' => 'nullable|string|regex:/^[a-zA-Z0-9\s\-\.]+$/|max:100',
            'motor_modelo' => 'nullable|string|regex:/^[a-zA-Z0-9\s\-\.]+$/|max:100',
            'motor_potencia' => 'nullable|integer|min:0|max:99999',
            'observaciones' => 'nullable|string|max:1000',
            'imagenes.*' => 'nullable|image|max:5120',
        ];
    }

    protected $messages = [
        'matricula.regex' => 'La matrícula solo puede contener letras mayúsculas, números y guiones.',
        'nombre.regex' => 'El nombre solo puede contener letras, números, espacios, guiones y puntos.',
        'material_casco.regex' => 'El material del casco solo puede contener letras, números, espacios, guiones y puntos.',
        'motor_marca.regex' => 'La marca del motor solo puede contener letras, números, espacios, guiones y puntos.',
        'motor_modelo.regex' => 'El modelo del motor solo puede contener letras, números, espacios, guiones y puntos.',
    ];

    public function mount(Embarcacion $embarcacion = null)
    {
        if (auth()->user()->role === 'empresa') {
            $this->empresa_id = auth()->user()->empresa_id;
        }

        if ($embarcacion && $embarcacion->exists) {
            $this->embarcacionId = $embarcacion->id;
            $this->fill($embarcacion->toArray());
            $this->loadImagenes();
        }
    }

    public function save()
    {
        $rules = $this->rules();
        if ($this->embarcacionId) {
            $rules['matricula'] = 'required|string|unique:embarcaciones,matricula,' . $this->embarcacionId;
        }

        $this->validate($rules);

        // Sanitización de datos
        $data = [
            'empresa_id' => $this->empresa_id,
            'matricula' => strtoupper(trim(strip_tags($this->matricula))),
            'nombre' => ucwords(strtolower(trim(strip_tags($this->nombre)))),
            'tipo' => $this->tipo,
            'capacidad_pasajeros' => $this->capacidad_pasajeros ? (int)$this->capacidad_pasajeros : null,
            'eslora' => $this->eslora ? (float)$this->eslora : null,
            'manga' => $this->manga ? (float)$this->manga : null,
            'tonelaje' => $this->tonelaje ? (float)$this->tonelaje : null,
            'ano_construccion' => $this->ano_construccion ? (int)$this->ano_construccion : null,
            'material_casco' => $this->material_casco ? ucfirst(trim(strip_tags($this->material_casco))) : null,
            'motor_marca' => $this->motor_marca ? ucfirst(trim(strip_tags($this->motor_marca))) : null,
            'motor_modelo' => $this->motor_modelo ? strtoupper(trim(strip_tags($this->motor_modelo))) : null,
            'motor_potencia' => $this->motor_potencia ? (int)$this->motor_potencia : null,
            'observaciones' => $this->observaciones ? trim(strip_tags($this->observaciones)) : null,
        ];

        if ($this->embarcacionId) {
            $embarcacion = Embarcacion::findOrFail($this->embarcacionId);
            $embarcacion->update($data);
            session()->flash('message', 'Embarcación actualizada exitosamente.');
        } else {
            $embarcacion = Embarcacion::create($data);
            $embarcacion->generateQrCode();
            session()->flash('message', 'Embarcación creada exitosamente.');
        }

        if ($this->imagenes) {
            foreach ($this->imagenes as $index => $imagen) {
                $path = $imagen->store('embarcaciones/imagenes', 'public');
                EmbarcacionImagen::create([
                    'embarcacion_id' => $embarcacion->id,
                    'ruta' => $path,
                    'es_principal' => $index === 0 && $embarcacion->imagenes()->count() === 0,
                    'orden' => $embarcacion->imagenes()->count() + $index,
                ]);
            }
        }

        return redirect()->route('embarcaciones.show', $embarcacion);
    }

    public function loadImagenes()
    {
        if ($this->embarcacionId) {
            $this->imagenesExistentes = Embarcacion::findOrFail($this->embarcacionId)->imagenes;
        }
    }

    public function deleteImagen($imagenId)
    {
        $imagen = EmbarcacionImagen::findOrFail($imagenId);
        \Storage::disk('public')->delete($imagen->ruta);
        $imagen->delete();
        $this->loadImagenes();
        session()->flash('message', 'Imagen eliminada exitosamente.');
    }

    public function render()
    {
        $empresas = auth()->user()->role === 'admin' || auth()->user()->role === 'inspector'
            ? Empresa::activa()->get()
            : [];

        return view('livewire.embarcaciones.form', [
            'empresas' => $empresas
        ])->layout('layouts.app');
    }
}
