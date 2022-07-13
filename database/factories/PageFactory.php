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
       
        $title = $this->faker->sentence(6, true);

        return [
            'created_by' => 1,
            'updated_by' => 1,
            'owned_by' => 1,
            'project_id' => $this->faker->numberBetween(1, 3),
            'section_id' => $this->faker->numberBetween(1, 6),
            'page_type' => 'page',
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->paragraph(12, true),
            'restricted' => 0,
            'current_revision' => 0
        ];
    }
}
