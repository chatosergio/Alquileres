<div> {{-- Div raíz de Livewire --}}

    {{-- Botón para abrir el modal --}}
    <div class="mb-6 flex justify-end">
        <flux:button wire:click="openModal" variant="primary" icon="plus">
            Nueva Propiedad
        </flux:button>
    </div>

    {{-- ─── SECCIÓN DE FILTROS ─────────────────────────────────── --}}
    <div class="mb-6 rounded-lg border border-outline bg-surface p-4 dark:border-outline-dark dark:bg-surface-dark">
        
        {{-- Título y botón limpiar --}}
        <div class="mb-4 flex items-center justify-between">
            <flux:heading size="base">Filtrar propiedades</flux:heading>
            
            @if ($filtroEstado || $filtroTipo)
                <flux:button size="sm" variant="ghost" icon="x-mark" wire:click="clearFilters">
                    Limpiar filtros
                </flux:button>
            @endif
        </div>

        {{-- Inputs de filtro --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            
            {{-- Filtro por Tipo --}}
            <div>
                <flux:input 
                    wire:model.live.debounce.300ms="filtroTipo" 
                    label="Tipo" 
                    placeholder="Ej: Casa, Depa..."
                    icon="magnifying-glass"
                />
            </div>

            {{-- Filtro por Estado --}}
            <div>
                <flux:select wire:model.live="filtroEstado" label="Estado">
                    <option value="">Todos los estados</option>
                    <option value="disponible">Disponible</option>
                    <option value="alquilado">Alquilado</option>
                    <option value="mantenimiento">Mantenimiento</option>
                </flux:select>
            </div>

            {{-- Contador de resultados --}}
            <div class="flex items-end">
                <flux:text class="text-sm text-on-surface-dark">
                    {{ $propiedades->total() }} 
                    {{ Str::plural('propiedad', $propiedades->total()) }} 
                    encontrada{{ $propiedades->total() !== 1 ? 's' : '' }}
                </flux:text>
            </div>
        </div>

        {{-- Badges de filtros activos --}}
        @if ($filtroEstado || $filtroTipo)
            <div class="mt-4 flex flex-wrap gap-2">
                @if ($filtroTipo)
                    <span class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                        Tipo: "{{ $filtroTipo }}"
                        <button wire:click="$set('filtroTipo', '')" class="ml-1 hover:text-blue-600">✕</button>
                    </span>
                @endif

                @if ($filtroEstado)
                    <span class="inline-flex items-center gap-1 rounded-full bg-purple-100 px-3 py-1 text-xs font-medium text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                        Estado: {{ ucfirst($filtroEstado) }}
                        <button wire:click="$set('filtroEstado', '')" class="ml-1 hover:text-purple-600">✕</button>
                    </span>
                @endif
            </div>
        @endif
    </div>

    {{-- Mensaje de éxito --}}
    @if (session()->has('message'))
        <div x-data x-init="Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: '{{ session('message') }}',
            showConfirmButton: false,
            timer: 1500
        });">
        </div>
    @endif

    {{-- Tabla de propiedades --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-on-surface dark:text-on-surface-dark">
            <thead
                class="border-b border-outline bg-surface-alt text-sm text-on-surface-strong dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark-strong">
                <tr>
                    <th scope="col" class="p-4">Tipo</th>
                    <th scope="col" class="p-4">Dirección</th>
                    <th scope="col" class="p-2">Precio</th>
                    <th scope="col" class="p-4">Estado</th>
                    <th scope="col" class="p-4">F.Creacion</th>
                    <th scope="col" class="p-4">F.Update</th>
                    <th scope="col" class="p-4 text-center">ACCIONES</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline dark:divide-outline-dark">
                @forelse($propiedades as $p)
                    <tr>
                        <td class="p-4 px-2">{{ $p->tipo }}</td>
                        <td class="p-4 px-2">{{ $p->direccion }}</td>
                        <td class="p-4">${{ number_format($p->precio, 2) }}</td>
                        <td class="p-4">
                            @if (strtolower($p->estado) === 'mantenimiento')
                                <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">
                                    Mantenimiento
                                </span>
                            @elseif(strtolower($p->estado) === 'disponible')
                                <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                    Disponible
                                </span>
                            @elseif(strtolower($p->estado) === 'alquilado')
                                <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">
                                    Alquilado
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">
                                    {{ $p->estado }}
                                </span>
                            @endif
                        </td>
                        <td class="p-4">{{ $p->created_at?->format('d/m/Y') }}</td>
                        <td class="p-4">{{ $p->updated_at?->format('d/m/Y') }}</td>

                        {{-- Columna de Acciones (solo editar) --}}
                        <td class="p-4 text-center">
                            <flux:button 
                                size="sm" 
                                variant="ghost" 
                                icon="pencil"
                                wire:click="edit({{ $p->id }})" 
                                wire:loading.attr="disabled" 
                            />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="p-6 text-center text-gray-500" colspan="7">
                            @if ($filtroEstado || $filtroTipo)
                                <div class="flex flex-col items-center gap-2">
                                    <flux:icon.magnifying-glass class="h-10 w-10 text-gray-300" />
                                    <p>No se encontraron propiedades con los filtros aplicados.</p>
                                    <flux:button size="sm" variant="ghost" wire:click="clearFilters">
                                        Limpiar filtros
                                    </flux:button>
                                </div>
                            @else
                                No se encontraron propiedades.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="mt-4">
        {{ $propiedades->links() }}
    </div>

    {{-- MODAL DE CREAR/EDITAR --}}
    <flux:modal wire:model="showModal" class="md:w-96 space-y-6">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">
                    {{ $editingId ? 'Editar Propiedad' : 'Registrar Propiedad' }}
                </flux:heading>
                <flux:text>
                    {{ $editingId ? 'Actualiza los datos de la propiedad.' : 'Completa los datos de la nueva propiedad.' }}
                </flux:text>
            </div>

            <form wire:submit="save" class="space-y-4">

                <div>
                    <flux:input wire:model="tipo" label="Tipo de propiedad" placeholder="Ej: Casa, Depa" />
                    @error('tipo')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <flux:input wire:model="direccion" label="Dirección" placeholder="Ej: Av. Principal 123" />
                    @error('direccion')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <flux:input wire:model="precio" label="Precio" type="number" step="0.01" placeholder="0.00" />
                    @error('precio')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <flux:textarea wire:model="descripcion" label="Descripción" placeholder="Detalles..." />
                    @error('descripcion')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <flux:select wire:model="estado" label="Estado">
                        <option value="disponible">Disponible</option>
                        <option value="alquilado">Alquilado</option>
                        <option value="mantenimiento">Mantenimiento</option>
                    </flux:select>
                    @error('estado')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-end gap-2 pt-4 mt-2">
                    <flux:button type="button" wire:click="closeModal" variant="ghost">
                        Cancelar
                    </flux:button>
                    <flux:button type="submit" variant="primary" wire:loading.attr="disabled">
                        {{ $editingId ? 'Actualizar' : 'Guardar' }}
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

</div> {{-- Fin del Div raíz de Livewire --}}