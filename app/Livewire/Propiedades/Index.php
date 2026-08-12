<?php

namespace App\Livewire\Propiedades;

use App\Models\Property;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';
    // ─── PROPIEDADES DE FILTROS ───────────────────────────────
    public $filtroEstado = '';
    public $filtroTipo = '';

    public $tipo;
    public $direccion;
    public $precio;
    public $esEdicion=false;
    public $descripcion;
    public $editingId = null;
    public $estado = 'disponible';

    public $showModal = false; // <--- Controla el modal

    protected $rules = [
        'tipo' => 'required|string|max:50',
        'direccion' => 'required|string',
        'precio' => 'required|numeric|min:0',
        'descripcion' => 'required|string',
        'estado' => 'required|in:disponible,alquilado,mantenimiento',
    ];

    protected function messages()
    {
        return [
            'tipo.required' => 'El campo tipo es obligatorio.',
            'tipo.string' => 'El campo tipo debe ser un texto.',
            'tipo.max' => 'El campo tipo no debe exceder los 50 caracteres.',
            'direccion.required' => 'El campo dirección es obligatorio.',
            'direccion.string' => 'El campo dirección debe ser un texto.',
            'precio.required' => 'El campo precio es obligatorio.',
            'precio.numeric' => 'El campo precio debe ser un número.',
            'precio.min' => 'El precio no puede ser menor que 0.',
            'descripcion.required' => 'El campo descripción es obligatorio.',
            'descripcion.string' => 'El campo descripción debe ser un texto.',
            'estado.required' => 'El campo estado es obligatorio.',
            'estado.in' => 'El estado seleccionado no es válido.',
        ];
    }

    // <--- MÉTODO QUE FALTABA
    public function openModal()
    {
        $this->resetForm();
        $this->resetValidation();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function resetForm()
    {
        $this->tipo = '';
        $this->direccion = '';
        $this->precio = '';
        $this->descripcion = '';
        $this->estado = 'disponible';
    }

    public function render()
    {
        /** si es con filtros */
         $propiedades = Property::query()
            // Filtro por Estado
            ->when($this->filtroEstado, function ($query) {
                $query->where('estado', $this->filtroEstado);
            })
            // Filtro por Tipo (búsqueda parcial con LIKE)
            ->when($this->filtroTipo, function ($query) {
                $query->where('tipo', 'like', '%' . $this->filtroTipo . '%');
            })
            ->latest('id')
            ->paginate(10);
        /* sin filtros*/    

        // $propiedades = Property::latest('id')->paginate(10);
        return view('livewire.propiedades.index', compact('propiedades'));
    }

    public function store()
    {
        $this->validate();

        Property::create([
            'tipo' => $this->tipo,
            'direccion' => $this->direccion,
            'precio' => $this->precio,
            'descripcion' => $this->descripcion,
            'estado' => $this->estado,
        ]);

        session()->flash('message', 'Propiedad creada exitosamente.');

        $this->closeModal();
        $this->resetPage();
    }
    public function edit($id)
    {
        // dd('Editando el registro con ID: ' . $id);
        $propiedad = Property::findOrFail($id);
        $this->editingId = $propiedad->id;
        $this->tipo = $propiedad->tipo;
        $this->direccion = $propiedad->direccion;
        $this->precio = $propiedad->precio;
        $this->descripcion = $propiedad->descripcion;
        $this->estado = $propiedad->estado;

        $this->showModal = true;
    }
     public function save()
    {
        $this->validate();

        Property::updateOrCreate(
            ['id' => $this->editingId],
            [
                'tipo'        => $this->tipo,
                'direccion'   => $this->direccion,
                'precio'      => $this->precio,
                'descripcion' => $this->descripcion,
                'estado'      => $this->estado,
            ]
        );
        $esEdicion=true;
        $this->showModal = false;
        $this->resetForm();

        session()->flash('message',  $esEdicion
            ? 'Propiedad actualizada con éxito'
            : 'Propiedad registrada con éxito'
        );
           
    }
     public function clearFilters()
    {
        $this->filtroEstado = '';
        $this->filtroTipo = '';
        $this->resetPage(); // Volver a la página 1
    }
}
