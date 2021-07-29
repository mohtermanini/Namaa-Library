<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Book::insert([
            [
                'title'=> 'فن الكلام وأصول الحوار الناجح',
                'author' => 'إيهاب فكري',
                'count' => 20,
                'available_count' => 19,
                'category_id' => '1',
            ],
            [
                'title'=> 'الثقة والاعتزاز بالنفس',
                'author' => 'إبراهيم الفقي',
                'count' => 3,
                'available_count' => 2,
                'category_id' => '1',
            ],
            [
                'title'=> 'إدارة الوقت',
                'author' => 'إبراهيم الفقي',
                'count' => 15,
                'available_count' => 14,
                'category_id' => '1',
            ],
            [
                'title'=> 'فن أن تكون دائما على صواب',
                'author' => 'آرثر شوبنهاور',
                'count' => 40,
                'available_count' => 39,
                'category_id' => '2',
            ],
            [
                'title'=> 'الثقافة والإمبريالية',
                'author' => 'إدوارد سعيد',
                'count' => 60,
                'available_count' => 60,
                'category_id' => '3',
            ]
        ]);
    }
}
