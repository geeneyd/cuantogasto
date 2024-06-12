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
                    <div class="overflow-x-auto">
                        <form action="{{ route('categories.update', $category) }}" method="POST" class="p-6">
                            @csrf @method('PUT')
                            <input type="hidden" name="icon" value="-">
                            <h1 class="text-center mb-4 text-xl font-bold text-gray-700">{{ __('Modificar Categoria') }}</h1>
                        
                            <div class="mb-4">
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name',$category->name)" required autofocus />
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
                                <span>{{ __('Modificar') }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>