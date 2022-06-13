<?php

use Illuminate\Database\Seeder;
use App\Models\Categories;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Categories::create(['title' => 'Equipment and tools', 'order' => 0, 'created_at' => now(), 'updated_at' => now()]);
        Categories::create(['title' => 'Ventilation', 'order' => 1, 'created_at' => now(), 'updated_at' => now()]);
        Categories::create(['title' => 'Lighting', 'order' => 2, 'created_at' => now(), 'updated_at' => now()]);
        Categories::create(['title' => 'Sanitation', 'order' => 3, 'created_at' => now(), 'updated_at' => now()]);
        Categories::create(['title' => 'Personnel hygiene', 'order' => 4, 'created_at' => now(), 'updated_at' => now()]);
    }
}
