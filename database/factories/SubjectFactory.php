<?php

namespace Database\Factories;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SubjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subject::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        //$user = User::factory()->create();
        $name = $this->faker->text(30);

        return [
            'user_id' => 1, //$user->id,
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraph(2, true)
        ];
    }
}
