<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Page;
use App\Models\User;
use App\Models\Project;
use App\Models\Section;
use App\Models\Subject;
use App\Models\RoleUser;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SectionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $user;

    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    private function create_user(int $role)
    {
        $this->user = User::factory()->create();
        RoleUser::factory()->create([
            'user_id' => $this->user->id,
            'role_id' => $role
        ]);

        return $this->user->role_user->role_id;
    }

    public function test_non_logged_user_cannot_access_sections_page()
    {
        $response = $this->get('/sections/create');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_logged_user_can_see_sections_list()
    {
        $this->create_user(1);
        $subject = Subject::factory()->create(['user_id' => $this->user->id]);
        $project = Project::factory()->create(['user_id' => $this->user->id, 'subject_id' => $subject->id]);
        $res = $this->actingAs($this->user)->get("projects/$project->slug/sections/create");
        $res->assertStatus(200);
        $res->assertSee('Save');
    }

    public function test_logged_user_can_create_section()
    {
        $this->create_user(1);
        $subject = Subject::factory()->create(['user_id' => $this->user->id]);
        $project = Project::factory()->create(['user_id' => $this->user->id, 'subject_id' => $subject->id]);
        $title = $this->faker->words(2, true);
        $description = $this->faker->paragraph(3, true);

        $res = $this->actingAs($this->user)->post('/sections/store', [
            'project_id' => $project->id,
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $description
        ]);
        $res->assertRedirect("/projects/$project->slug");

        $this->assertDatabaseHas('sections', [
            'project_id' => $project->id,
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $description
        ]);
    }

    public function test_logged_user_can_update_section()
    {
        $this->withoutExceptionHandling();
        $this->create_user(1);
        $subject = Subject::factory()->create([
            'user_id' => $this->user->id
        ]);
        $project = Project::factory()->create([
            'user_id' => $this->user->id, 
            'subject_id' => $subject->id
        ]);
        $section = Section::factory()->create([
            'project_id' => $project->id
        ]);

        $res = $this->actingAs($this->user)->put("sections/$section->slug", [
            'project_id' => $project->id,
            'title' => $section->title,
            'slug' => $section->slug,
            'description' => $section->description
        ]);
        $res->assertStatus(302);
        $res->assertRedirect(route('projects.show', $project->slug));
        $this->assertDatabaseHas('sections', [
            'project_id' => $project->id,
            'title' => $section->title,
            'slug' => $section->slug,
            'description' => $section->description
        ]);
    }

    public function test_logged_user_can_delete_section()
    {
        $this->create_user(1);
        $subject = Subject::factory()->create([
            'user_id' => $this->user->id
        ]);
        $project = Project::factory()->create([
            'user_id' => $this->user->id, 
            'subject_id' => $subject->id
        ]);
        $section = Section::factory()->create([
            'project_id' => $project->id
        ]);
        $page = Page::factory()->create([
            'project_id' => $project->id,
            'section_id' => $section->id
        ]);
        $pg = [
            'title' => 'The test',
            'content' => 'Blah blah',
            'page_type' => 'page',
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
            'owned_by' => $this->user->id,
            'slug' => 'the-test'
        ];
        $this->assertEquals(1, $section->count());
        $res = $this->actingAs($this->user)->delete('sections/' . $section->slug);
        $res->assertRedirect(route('projects.show', $project->slug));
        $this->assertEquals(0, $section->count());
        $this->assertDatabaseMissing('pages', $pg);
        $res->assertSessionHas('success');
    }
}
