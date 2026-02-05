<?php

namespace Database\Seeders;

use App\Models\PropertyType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('property_types')->delete();

        PropertyType::create([
            'id' => 1,
            'name' => 'Sale',
        ]);
        PropertyType::create([
            'id' => 2,
            'name' => 'Rent',
        ]);
    }
}