<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Salario',
                'icon' => 'fa-salary',
                'type' => 'income',
                'user_id' => null,
            ],
            [
                'name' => 'Ventas',
                'icon' => 'fa-sales',
                'type' => 'income',
                'user_id' => null,
            ],
            [
                'name' => 'Hogar',
                'icon' => 'fa-food',
                'type' => 'spent',
                'user_id' => null,
            ],
            [
                'name' => 'Comida',
                'icon' => 'fa-food',
                'type' => 'spent',
                'user_id' => null,
            ],
            [
                'name' => 'Transporte',
                'icon' => 'fa-transport',
                'type' => 'spent',
                'user_id' => null,
            ],
        ]);
    }
}
