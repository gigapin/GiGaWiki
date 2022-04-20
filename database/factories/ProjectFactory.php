<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        //$user = User::factory()->create();
        $subject = Subject::factory()->create();
        $name = $this->faker->sentence(3, true);

        return [
            'user_id' => 1, //$user->id,
            'subject_id' => $subject->id,
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraph(3, true),
            'image_id' => NULL
        ];
    }
}
