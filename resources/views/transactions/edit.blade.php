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
                    <div class="overflow-x-auto">
                        @if ($transaction->type === 'expense')
                        <form action="{{ route('transactions.update', $transaction) }}" method="POST" class="p-6">
                            @csrf @method('PUT')
                            <input type="hidden" name="type" value="expense">
                            <h1 class="text-center mb-4 text-xl font-bold text-red-500">{{ __('Editar Gasto') }}</h1>
                        
                            <!-- Campo de descripción -->
                            <div class="mb-4">
                                <x-input-label for="expense_description" :value="__('Description')" />
                                <x-text-input id="expense_description" class="block mt-1 w-full" type="text" name="expense_description" :value="old('expense_description', $transaction->description)" required autofocus />
                                @error('expense_description')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>
                        
                            <!-- Campo de cantidad -->
                            <div class="mb-4">
                                <x-input-label for="expense_amount" :value="__('Amount')" />
                                <x-text-input id="expense_amount" class="block mt-1 w-full" type="number" name="expense_amount" :value="old('expense_amount', $transaction->amount)" required autofocus />
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
                                {{ __('Editar') }}
                            </button>
                        </form>
                        @else
                        <form action="{{ route('transactions.update', $transaction) }}" method="POST" class="p-6">
                            @csrf @method('PUT')
                            <input type="hidden" name="type" value="income">
                            <h1 class="text-center mb-4 text-xl font-bold text-green-700">{{ __('Editar Ingreso') }}</h1>
                        
                            <!-- Campo de descripción -->
                            <div class="mb-4">
                                <x-input-label for="income_description" :value="__('Description')" />
                                <x-text-input id="income_description" class="block mt-1 w-full" type="text" name="income_description" :value="old('income_description', $transaction->description)" required autofocus />
                                @error('income_description')
                                    <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            </div>
                        
                            <!-- Campo de cantidad -->
                            <div class="mb-4">
                                <x-input-label for="income_amount" :value="__('Amount')" />
                                <x-text-input id="income_amount" class="block mt-1 w-full" type="number" name="income_amount" :value="old('income_amount', $transaction->amount)" required autofocus />
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
                                <span>{{ __('Editar') }}</span>
                            </button>
                        </form>  
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>