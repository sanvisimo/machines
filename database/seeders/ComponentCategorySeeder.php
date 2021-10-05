<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComponentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $categories = [
            ['id' => 1, 'name' => 'Machine regulator'],
            ['id' => 2, 'name' => 'Driving machines'],
            ['id' => 3, 'name' => 'Rotation transmission machines'],
            ['id' => 4, 'name' => 'Liquid machines'],
            ['id' => 5, 'name' => 'Compressor machines'],
            ['id' => 6, 'name' => 'Fan machines'],
        ];


        DB::table('component_categories')->insert($categories);
    }
}
