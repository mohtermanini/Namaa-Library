<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionType;

class SubscriptionTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubscriptionType::insert([
            [
                'name' => 'داخلي',
                'days'=>7,
                'fee'=>500
            ],
            [
                'name' => 'خارجي',
                'days'=>30,
                'fee'=>1000
            ],
            [
                'name' => 'مقهى الوظائف',
                'days'=>30,
                'fee'=>5000
            ],
            [
                'name' => 'نشاطات المكتبة',
                'days'=>1,
                'fee'=>300
            ],
            [
                'name' => 'مدرس',
                'days'=>null,
                'fee'=>null
            ]
        ]);
    }
}
