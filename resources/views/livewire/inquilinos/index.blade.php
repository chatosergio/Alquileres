<div>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            <h2 class="mb-4 text-xl font-semibold text-neutral-900 dark:text-white">
                Listado Inquilinos
            </h2>

            <div
                class="overflow-hidden w-full overflow-x-auto rounded-sm border border-neutral-300 dark:border-neutral-700">
                <table class="w-full text-left text-sm text-neutral-600 dark:text-neutral-300">
                    <thead
                        class="border-b border-neutral-300 bg-neutral-50 text-sm text-neutral-900 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white">
                        <tr>
                            <th scope="col" class="p-4">Nombre</th>
                            <th scope="col" class="p-4">Apellido</th>
                            <th scope="col" class="p-4">Cedula</th>
                            <th scope="col" class="p-4">Email</th>
                            <th scope="col" class="p-4">Teléfono</th>
                            <th scope="col" class="p-4">Acciones</th>

                        </tr>
                        </tr>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-300 dark:divide-neutral-700">
                        @forelse ($trents as $trent)
                            <tr class="even:bg-black/5 dark:even:bg-white/10">

                                <td class="p-4">{{ $trent->nombre }}</td>
                                <td class="p-4">{{ $trent->apellido }}</td>
                                <td class="p-4">{{ $trent->cedula }}</td>
                                <td class="p-4">{{ $trent->email }}</td>
                                <td class="p-4">{{ $trent->telefono }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-4 text-center">
                                    No hay inquilinos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
              {{ $trents->links('vendor.livewire.tailwind') }}
            </div>
        </div>
    </div>
</div>
