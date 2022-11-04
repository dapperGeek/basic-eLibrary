<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->unique()->word(),
            'isbn' => $this->faker->numerify('###-#-####-##'),
            'revision_number' => $this->faker->numberBetween(1, 9),
            'published_date' => $this->faker->dateTimeBetween($startDate = '-30 years', $endDate = '-4 years'),
            'publisher' => $this->faker->company(),
            'author' => $this->faker->name(),
            'genre' => $this->faker->word(),
            'synopsis' => $this->faker->text($maxNbChars = 250),
            'added_date' => $this->faker->dateTimeBetween($startDate = '-4 years', $endDate = 'now'),
        ];
    }
}
