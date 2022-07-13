<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::factory()->create();
        $name = Str::random(40) . '.png';
        $type = $this->faker->randomElement(['post', 'cover']);

        return [
            'name' => $name,
            'url' => 'http://' . config('app.url') . '/storage/uploads/' . $user->id . '/' . $name,
            'path' => '/uploads/' . $user->id . '/' . $name,
            'created_by' => $user->id,
            'updated_by' => $user->id,
            'type' => $type
        ];
    }
}
