<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'modal')" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                        {{ __('Nueva Categoria') }}
                    </button>

                    @if(session('success'))
                        <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Bien!</strong>
                            <span class="block sm:inline">{{ __(session('success')) }}</span>
                        </div>
                    @endif

                    <br><br>    

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($categories as $category)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($category->name) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="@if($category->type === 'income') text-green-600 @elseif($category->type === 'spent') text-red-600 @endif">
                                                {{ __($category->type) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if(is_numeric($category->user_id))
                                                <a href="{{ route('categories.edit', $category->id) }}" class="text-indigo-600 hover:text-indigo-900 inline-block bg-transparent text-blue-600 font-semibold hover:text-blue-800 py-2 px-4 border border-blue-500 hover:border-blue-800 rounded">Editar</a>
                                                <button type="button" onclick="confirmDelete({{ $category->id }})" class="text-red-600 hover:text-red-900 ml-2 inline-block bg-transparent text-red-600 font-semibold hover:text-red-800 py-2 px-4 border border-red-500 hover:border-red-800 rounded">Eliminar</button>
                                            @endif
                                            <!-- Formulario de eliminación -->
                                            <form id="deleteForm{{ $category->id }}" action="{{ route('categories.destroy', $category->id) }}" method="POST" class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                               

                      
                    <!-- MODAL -->
                    <x-modal name="modal" focusable>
                        <form action="{{ route('categories.store') }}" method="POST" class="p-6">
                            @csrf
                            
                            <input type="hidden" name="icon" value="-">
                            <h1 class="text-center mb-4 text-xl font-bold text-gray-700">{{ __('Nueva Categoria') }}</h1>
                        
                            <div class="mb-4">
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                                @error('name')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>                            
                            
                            <div class="mb-4">
                                <x-input-label for="type" :value="__('Tipo de Categoria')" />
                                <select name="type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1" required autofocus>
                                    <option value="">Selecciona el tipo de categoría</option>
                                    <option value="income">Ingreso</option>
                                    <option value="spent">Gasto</option>
                                </select>
                                @error('type')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>                            

                            <!-- Botón de envío -->
                            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 w-full bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                                <span>{{ __('Nueva Categoria') }}</span>
                            </button>
                        </form>                        
                    </x-modal>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    function confirmDelete(categoryId) {
        // Utilizando la función confirm() de JavaScript
        if (confirm("Esta acción eliminará permanentemente la categoría y todas las transacciones asociadas.")) {
            // Si el usuario confirma, se envía el formulario de eliminación
            document.getElementById("deleteForm" + categoryId).submit();
        }
    }
</script>