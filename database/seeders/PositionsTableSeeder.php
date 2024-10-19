<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = [
            ['name' => 'Lawyer'],
            ['name' => 'Designer'],
            ['name' => 'Software Engineer'],
            ['name' => 'Data Analyst'],
            ['name' => 'Project Manager'],
            ['name' => 'Marketing Specialist'],
            ['name' => 'Accountant'],
            ['name' => 'Sales Manager'],
            ['name' => 'Human Resources Manager'],
            ['name' => 'Customer Service Representative']
        ];

        foreach ($positions as $position) {
            DB::table('positions')->insert([
                'name' => $position['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
