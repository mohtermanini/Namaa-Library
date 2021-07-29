<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SessionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $session = \App\Models\Session::create([
                'course_id' => 1,
                'date' => '2021-06-04'
        ]);
        $session->users()->attach(3,['paid'=>1000]);
        $session->users()->attach(4,['paid'=>1000]);

        $session = \App\Models\Session::create([
            'course_id' => 2,
            'date' => '2021-06-12'
        ]);
        $session->users()->attach(3,['paid'=>500]);

    }
}
