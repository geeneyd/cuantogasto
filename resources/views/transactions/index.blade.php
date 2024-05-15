<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transactions') }}
        </h2>
    </x-slot>

    <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'modal-income')" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                        {{ __('New Entry') }}
                    </button>
                    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'modal-expense')" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                        {{ __('New Expense') }}
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
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripcion</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoria</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->description }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->amount }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="@if($transaction->type === 'income') text-green-600 @elseif($transaction->type === 'expense') text-red-600 @endif">
                                                {{ __($transaction->type) }}
                                            </span>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->category->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->created_at->format('Y-m-d') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <!--<a href="{{ route('transactions.edit', $transaction->id) }}" class="text-indigo-600 hover:text-indigo-900 inline-block bg-transparent text-blue-600 font-semibold hover:text-blue-800 py-2 px-4 border border-blue-500 hover:border-blue-800 rounded">Editar</a>-->

                                            <button type="button" onclick="confirmDelete({{ $transaction->id }})" class="text-red-600 hover:text-red-900 ml-2 inline-block bg-transparent text-red-600 font-semibold hover:text-red-800 py-2 px-4 border border-red-500 hover:border-red-800 rounded">Eliminar</button>

                                            <!-- Formulario de eliminación -->
                                            <form id="deleteForm{{ $transaction->id }}" action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                               

                      
                    <!-- MODAL INGRESOS -->
                    <x-modal name="modal-income" focusable>
                        <form action="{{ route('transactions.store') }}" method="POST" class="p-6">
                            @csrf
                            <input type="hidden" name="type" value="income">
                            <h1 class="text-center mb-4 text-xl font-bold text-green-700">{{ __('New Entry') }}</h1>
                        
                            <!-- Campo de descripción -->
                            <div class="mb-4">
                                <x-input-label for="income_description" :value="__('Description')" />
                                <x-text-input id="income_description" class="block mt-1 w-full" type="text" name="income_description" :value="old('income_description')" required autofocus />
                                @error('income_description')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>
                        
                            <!-- Campo de cantidad -->
                            <div class="mb-4">
                                <x-input-label for="income_amount" :value="__('Amount')" />
                                <x-text-input id="income_amount" class="block mt-1 w-full" type="number" name="income_amount" :value="old('income_amount')" required autofocus />
                                @error('income_amount')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>
                        
                            <!-- Campo de categoría -->
                            <div class="mb-4">
                                <x-input-label for="income_category_id" :value="__('Category')" />
                                <select name="income_category_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1" required autofocus >
                                    <option value="">Selecciona una categoría</option>
                                    @foreach($userCategories as $category)
                                        @if ($category->type === 'income')
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('income_category_id')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>
                        
                            <!-- Botón de envío -->
                            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                                <span>{{ __('New Entry') }}</span>
                            </button>
                        </form>                        
                    </x-modal>

                    <!-- MODAL GASTOS -->
                    <x-modal name="modal-expense" focusable>
                        <form action="{{ route('transactions.store') }}" method="POST" class="p-6">
                            @csrf
                            <input type="hidden" name="type" value="expense">
                            <h1 class="text-center mb-4 text-xl font-bold text-red-500">{{ __('New Expense') }}</h1>
                        
                            <!-- Campo de descripción -->
                            <div class="mb-4">
                                <x-input-label for="expense_description" :value="__('Description')" />
                                <x-text-input id="expense_description" class="block mt-1 w-full" type="text" name="expense_description" :value="old('expense_description')" required autofocus />
                                @error('expense_description')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>
                        
                            <!-- Campo de cantidad -->
                            <div class="mb-4">
                                <x-input-label for="expense_amount" :value="__('Amount')" />
                                <x-text-input id="expense_amount" class="block mt-1 w-full" type="number" name="expense_amount" :value="old('expense_amount')" required autofocus />
                                @error('expense_amount')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>
                        
                            <!-- Campo de categoría -->
                            <div class="mb-4">
                                <x-input-label for="expense_category_id" :value="__('Category')" />
                                <select name="expense_category_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1" required autofocus >
                                    <option value="">Selecciona una categoría</option>
                                    @foreach($userCategories as $category)
                                        @if ($category->type === 'spent')
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('expense_category_id')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>
                        
                            <!-- Botón de envío -->
                            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                                {{ __('New Expense') }}
                            </button>
                        </form>
                    </x-modal>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    function confirmDelete(transactionId) {
        // Utilizando la función confirm() de JavaScript
        if (confirm("¿Estás seguro de que quieres eliminar este registro?")) {
            // Si el usuario confirma, se envía el formulario de eliminación
            document.getElementById("deleteForm" + transactionId).submit();
        }
    }
</script>