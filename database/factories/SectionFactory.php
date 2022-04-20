<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Section::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $project = Project::factory()->create();
        $title = $this->faker->words(2, true);

        return [
            'project_id' => $project->id,
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraph(3, true)
        ];
    }
}
