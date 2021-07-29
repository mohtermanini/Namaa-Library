<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Category::insert([
            [
                'name' => 'التنمية البشرية وتطوير الذات'
            ],
            [
                'name' => 'علم الفلسفة والمنطق'
            ],
            [
                'name' => 'الثقافة الغربية'
            ],
            [
                'name' => 'دواوين وأشعار'
            ]
        ]);
    }
}
