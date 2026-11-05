<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            // Привязываем комментарий к случайной существующей статье
            'article_id' => Article::factory(), 
            'author'     => $this->faker->name(),
            'content'    => $this->faker->paragraph(2),
        ];
    }
}