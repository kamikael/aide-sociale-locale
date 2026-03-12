<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CagnotteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'organisateur_id' => null,
            'slug' => $this->faker->unique()->slug,
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'image_path' => null,
            'video_url' => null,
            'target_amount' => 100000,
            'collected_amount' => 0,
            'status' => 'active',
            'published_at' => now(),
        ];
    }
}