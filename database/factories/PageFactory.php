<?php

namespace Database\Factories;

use App\Models\Page;
use App\Models\Project;
use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Page::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $project = Project::factory()->create();
        $section = Section::factory()->create();
        $title = $this->faker->sentence(6, true);

        return [
            'created_by' => 1,
            'updated_by' => 1,
            'owned_by' => 1,
            'project_id' => $project->id,
            'section_id' => $section->id,
            'page_type' => 'page',
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->paragraphs(8, true),
            'restricted' => 0,
            'current_revision' => 0
        ];
    }
}
