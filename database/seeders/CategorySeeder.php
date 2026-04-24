<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Trabajo', 'Estudio', 'Personal', 'Ideas'];

        foreach ($categories as $name) {
            Category::create([
                'name' => $name,
                'description' => $name . ' category',
            ]);
        }
    }
}
