<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SubscriptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Subscription::insert([
            [
                'start_date' => '2021-06-22',
                'end_date' => '2021-06-29',
                'fee' => 500,
                'type_id' => 1,
                'user_id' => 1
            ],
            [
                'start_date' => '2021-06-09',
                'end_date' => '2021-07-09',
                'fee' => 1000,
                'type_id' => 2,
                'user_id' => 1
            ],
            [
                'start_date' => '2021-04-22',
                'end_date' => '2021-05-02',
                'fee' => 5000,
                'type_id' => 3,
                'user_id' => 1
            ],
            [
                'start_date' => '2021-06-16',
                'end_date' => '2021-07-06',
                'fee' => 4000,
                'type_id' => 3,
                'user_id' => 1
            ],
            [
                'start_date' => '2021-06-23',
                'end_date' => '2021-06-24',
                'fee' => 300,
                'type_id' => 4,
                'user_id' => 1
            ],
            [
                'start_date' => '2021-06-08',
                'end_date' => '2021-06-09',
                'fee' => 300,
                'type_id' => 4,
                'user_id' => 1
            ],
            [
                'start_date' => '2021-05-09',
                'end_date' => '2021-05-16',
                'fee' => 500,
                'type_id' => 1,
                'user_id' => 1
            ],
            [
                'start_date' => '2021-06-23',
                'end_date' => '2021-07-23',
                'fee' => 1000,
                'type_id' => 2,
                'user_id' => 2
            ],
            [
                'start_date' => '2021-06-23',
                'end_date' => '2023-12-10',
                'fee' => 50000,
                'type_id' => 4,
                'user_id' => 2
            ],
            [
                'start_date' => '2021-06-11',
                'end_date' => '2023-05-17',
                'fee' => 90000,
                'type_id' => 3,
                'user_id' => 2
            ],
            [
                'start_date' => '2020-04-17',
                'end_date' => null,
                'fee' => 0,
                'type_id' => 5,
                'user_id' => 3
            ],
            [
                'start_date' => '2020-09-04',
                'end_date' => null,
                'fee' => 0,
                'type_id' => 5,
                'user_id' => 4
            ]
        ]);
    }
}
