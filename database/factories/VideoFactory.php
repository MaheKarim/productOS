<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\AiProvider;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'youtube_url' => 'https://www.youtube.com/watch?v=' . $this->faker->regexify('[A-Za-z0-9_-]{11}'),
            'video_id_str' => $this->faker->regexify('[A-Za-z0-9_-]{11}'),
            'channel_name' => $this->faker->company() . ' Tech',
            'channel_logo' => $this->faker->imageUrl(64, 64, 'business'),
            'channel_id' => 'UC' . $this->faker->regexify('[A-Za-z0-9_-]{22}'),
            'title' => $this->faker->sentence(6),
            'thumbnail_url' => $this->faker->imageUrl(640, 480, 'technics'),
            'upload_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'duration' => $this->faker->numberBetween(5, 60) . ':00',
            'view_count' => $this->faker->numberBetween(1000, 1000000),
            'transcript' => $this->faker->paragraphs(5, true),
            'transcript_fetched_at' => now(),
            'access_level' => 'free',
            'processing_status' => 'pending',
            'ai_provider_id' => AiProvider::first()->id ?? AiProvider::factory(),
            'system_prompt' => null,
        ];
    }

    public function premium()
    {
        return $this->state(fn(array $attributes) => [
            'access_level' => 'premium',
        ]);
    }

    public function free()
    {
        return $this->state(fn(array $attributes) => [
            'access_level' => 'free',
        ]);
    }

    public function completed()
    {
        return $this->state(fn(array $attributes) => [
            'processing_status' => 'completed',
        ]);
    }
}
