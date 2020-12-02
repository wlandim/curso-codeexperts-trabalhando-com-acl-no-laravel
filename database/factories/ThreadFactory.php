<?php

namespace Database\Factories;

use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ThreadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Thread::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence;
        return [
            'channel_id' => function() {
                return Channel::factory()->create()->id;
            },
            'user_id' => function() {
                return User::factory()->create()->id;
            },
            'title' => $title,
            'body' => $this->faker->paragraph(2),
            'slug' => Str::slug($title),
        ];
    }
}
