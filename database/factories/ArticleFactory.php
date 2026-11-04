<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->sentence(rand(3, 6));

        return [
            'title'             => $title,
            'slug'              => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1, 99999),
            'short_description' => $this->faker->text(120),
            'description'       => $this->faker->paragraphs(3, true),
            'preview_image'     => 'preview.jpg',
            'full_image'        => 'full.jpeg',
            'published_at'      => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
