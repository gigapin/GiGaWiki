<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Section;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class LectureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $user;

    private function create_user()
    {
        $this->user = User::factory()->create();
    }

    public function test_non_logged_user_cannot_create_lecture()
    {
        $this->create_user();
        $project = Project::factory()->create(['user_id' => $this->user->id]);
        $section = Section::factory()->create(['project_id' => $project->id]);
        $res = $this->get("projects/$project->slug/sections/$section->slug/pages/create");
        $res->assertRedirect('/login');
    }

    public function test_logged_user_can_create_lecture()
    {
        $this->create_user();
        $project = Project::factory()->create(['user_id' => $this->user->id]);
        $section = Section::factory()->create(['project_id' => $project->id]);
        $title = $this->faker->sentence(6, true);
        $slug = Str::slug($title);
        $body = $this->faker->paragraphs(8, true);
        $res = $this->actingAs($this->user)->post("pages/store", [
            'user_id' => $this->user->id,
            'project_id' => $project->id,
            'section_id' => $section->id,
            'title' => $title,
            'slug' => $slug,
            'body' => $body,
            'lecture_type' => 'post',
        ]);
        $res->assertRedirect("pages/$slug");
        $this->assertDatabaseHas('pages', [
            'user_id' => $this->user->id,
            'project_id' => $project->id,
            'section_id' => $section->id,
            'title' => $title,
            'slug' => $slug,
            'body' => $body,
            'lecture_type' => 'post',
        ]);
    }
}
