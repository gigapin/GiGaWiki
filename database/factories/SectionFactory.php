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
        $title = $this->faker->words(3, true);

        return [
            'project_id' => $this->faker->numberBetween(1, 10),
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => null
        ];
    }
}
