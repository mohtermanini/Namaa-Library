<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BookSubscriptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Borrow::insert([
            [
                'subscription_id' => 1,
                'book_id' => 1,
                'borrow_date' => '2021-06-23 00:10:09',
                'return_date' => null,
                'identity_national_num' => null,
                'mortgage_amount' => 0 

            ],
            [
                'subscription_id' => 1,
                'book_id' => 4,
                'borrow_date' => '2021-06-23 00:10:09',
                'return_date' => null,
                'identity_national_num' => null,
                'mortgage_amount' => 0 

            ],
            [
                'subscription_id' => 2,
                'book_id' => 3,
                'borrow_date' => '2021-06-23 00:13:13',
                'return_date' => null,
                'identity_national_num' => '0112457885',
                'mortgage_amount' => 1000 

            ],
            [
                'subscription_id' => 2,
                'book_id' => 1,
                'borrow_date' => '2021-06-20 00:13:13',
                'return_date' => '2021-06-21',
                'identity_national_num' => null,
                'mortgage_amount' => 0 

            ],
            [
                'subscription_id' => 2,
                'book_id' => 2,
                'borrow_date' => '2021-06-23 00:13:13',
                'return_date' => null,
                'identity_national_num' => null,
                'mortgage_amount' => 0 

            ]
        ]);
    }
}
