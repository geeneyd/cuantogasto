<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="container mx-auto px-4 py-8">
                    <div class="mb-8">
                        <h1 class="text-2xl font-bold mb-4">Resumen Financiero del Mes</h1>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="bg-green-200 p-4 rounded shadow">
                                <h2 class="text-lg font-bold mb-2">Ingresos Totales</h2>
                                <p class="text-xl">$ 4.660.500 </p>
                            </div>
                            <div class="bg-red-200 p-4 rounded shadow">
                                <h2 class="text-lg font-bold mb-2">Gastos Totales</h2>
                                <p class="text-xl">$ 3.970.000 </p>
                            </div>
                            <div class="bg-blue-200 p-4 rounded shadow">
                                <h2 class="text-lg font-bold mb-2">Saldo del Mes</h2>
                                <p class="text-xl">$ 690.500 </p>
                            </div>
                        </div>
                    </div>
                
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold mb-4">Top 5 Categorías</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <h3 class="text-lg font-bold mb-2">Categorías con más Ingresos</h3>
                                <ul>
                                    <li>Salario: $ 3.000.000 </li>
                                    <li>Ventas: $ 1.000.000 </li>
                                    <li>Comisiones: $ 140.500 </li>
                                    <li>Alquiler: $ 500.000 </li>
                                    <li>Intereses: $ 20.500 </li>
                                </ul>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold mb-2">Categorías con más Gastos</h3>
                                <ul>
                                    <li>Comida: $ 700.560 </li>
                                    <li>Transporte: $ 400.200 </li>
                                    <li>Facturas: $ 300.000 </li>
                                    <li>Entretenimiento: $ 70.000 </li>
                                    <li>Salud: $ 50.000 </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                
                    <div>
                        <h2 class="text-2xl font-bold mb-4">Filtrar por Rango de Fechas</h2>
                        <form action="#" method="GET" class="flex flex-col sm:flex-row sm:items-center">
                            <div class="mb-4 sm:mr-4">
                                <label for="start_date" class="block mb-2">Fecha de inicio:</label>
                                <input type="date" id="start_date" name="start_date" class="px-4 py-2 border rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div class="mb-4 sm:mr-4">
                                <label for="end_date" class="block mb-2">Fecha de fin:</label>
                                <input type="date" id="end_date" name="end_date" class="px-4 py-2 border rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Filtrar</button>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>
