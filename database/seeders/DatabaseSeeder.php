<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\Customer::factory(1)->create();
        \App\Models\Machine::factory(1)->create();
        \App\Models\Activity::factory(1)->create();

        $categories = [
            ['id' => 1, 'name' => 'Machine regulator'],
            ['id' => 2, 'name' => 'Driving machines'],
            ['id' => 3, 'name' => 'Rotation transmission machines'],
            ['id' => 4, 'name' => 'Liquid machines'],
            ['id' => 5, 'name' => 'Compressor machines'],
            ['id' => 6, 'name' => 'Fan machines'],
        ];

        DB::table('component_categories')->insert($categories);

        $subcategories = [
            ['id' => 1, 'name' => 'Speed Regulator', 'component_category_id' => 1],
            ['id' => 2, 'name' => 'Electric motor', 'component_category_id' => 2],
            ['id' => 3, 'name' => 'Steam turbine', 'component_category_id' => 2],
            ['id' => 4, 'name' => 'Gas turbine', 'component_category_id' => 2],
            ['id' => 5, 'name' => 'Internal combustion engine', 'component_category_id' => 2],
            ['id' => 6, 'name' => 'Gear box', 'component_category_id' => 3],
            ['id' => 7, 'name' => 'OH pump', 'component_category_id' => 4],
            ['id' => 8, 'name' => 'BB pump', 'component_category_id' => 4],
            ['id' => 9, 'name' => 'Screw pump', 'component_category_id' => 4],
            ['id' => 10, 'name' => 'Lobe type pump', 'component_category_id' => 4],
            ['id' => 11, 'name' => 'Diaphragm pump', 'component_category_id' => 4],
            ['id' => 12, 'name' => 'Piston pump', 'component_category_id' => 4],
            ['id' => 13, 'name' => 'Blower', 'component_category_id' => 5],
            ['id' => 14, 'name' => 'Centrifugal compressor', 'component_category_id' => 5],
            ['id' => 15, 'name' => 'Reciprocating compressor', 'component_category_id' => 5],
            ['id' => 16, 'name' => 'Liquid ring compressors', 'component_category_id' => 5],
            ['id' => 17, 'name' => 'Centrifugal fan', 'component_category_id' => 6],
            ['id' => 18, 'name' => 'Axial fan', 'component_category_id' => 6],
        ];


        DB::table('component_sub_categories')->insert($subcategories);

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
