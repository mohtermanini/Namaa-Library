<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        // \App\Models\User::factory(10)->create();
        $this->call(SubscriptionTypesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(BooksTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(SubscriptionsTableSeeder::class);
        $this->call(BookSubscriptionsTableSeeder::class);
        $this->call(CoursesTableSeeder::class);
        $this->call(SessionsTableSeeder::class);


    }
}
