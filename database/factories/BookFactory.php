<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $count = $this->faker->numberBetween(20,30);
        return [
            'title'=>$this->faker->words(3,true),
            'author'=>$this->faker->name(),
            'count'=>$count,
            'available_count'=>$count,
            'category_id'=>$this->faker->numberBetween(1,Category::max('id'))
        ];
    }
}
