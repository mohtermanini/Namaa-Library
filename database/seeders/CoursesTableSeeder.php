<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Course::insert([
            [
                'name' => 'رياضيات'
            ],
            [
                'name' => 'جغرافيا'
            ],
            [
                'name' => 'تاريخ'
            ],
            [
                'name' => 'إنجليزي'
            ]
        ]);
    }
}
