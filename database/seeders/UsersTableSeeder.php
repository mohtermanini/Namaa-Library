<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::insert([
            [
                'name' => 'أنور لبابيدي',
                'birthdate' => '1977-12-01',
                'study' => 'هندسة مدنية',
                'address' => 'الشهباء القديمة',
                'mobile_1' => '0924122521',
                'mobile_2' => '0994277413',
                'phone_num' => '4213434'
            ],
            [
                'name' => 'هيثم أملح',
                'birthdate' => '1997-02-07',
                'study' => 'طب أسنان',
                'address' => 'العزيزية',
                'mobile_1' => '0984755626',
                'mobile_2' => null,
                'phone_num' => null
            ],
            [
                'name' => 'عمار ميسر',
                'birthdate' => '1980-04-21',
                'study' => 'كلية علوم',
                'address' => 'الشهباء القديمة',
                'mobile_1' => '0988544758',
                'mobile_2' => null,
                'phone_num' => '5668475'
            ],
            [
                'name' => 'عامر ريس',
                'birthdate' => '1984-02-24',
                'study' => 'كلية علوم',
                'address' => 'الموجامبو',
                'mobile_1' => '0987551235',
                'mobile_2' => null,
                'phone_num' => '9856325'
            ]
        ]);

    }
}
