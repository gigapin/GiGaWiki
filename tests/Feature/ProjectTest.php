<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use App\Models\RoleUser;
use App\Models\Subject;
use App\Models\Tag;
use App\Models\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 *
 */
class ProjectTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @var
     */
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

    public function test_non_logged_user_cannot_access_index_page()
    {
        $res = $this->get('projects');
        $res->assertStatus(302);
        $res->assertRedirect('login');
    }

    /**
     * Logged user can see whole projects lists.
     *
     * @return void
     */
    public function test_logged_user_can_see_projects_list()
    {
        $this->create_user(1);
        $projects = Project::factory()->create([
            'user_id' => $this->user->id
        ]);
        $res = $this->actingAs($this->user)->get('/projects');
        $res->assertStatus(200);
        $view = $res->viewData('projects');
        $this->assertEquals($projects->name, $view->last()->name);
    }

    public function test_logged_user_cannot_see_seventh_project_from_list()
    {
        $this->create_user(1);
        $projects = Project::factory(10)->create([
            'user_id' => $this->user->id,
        ]);
        $res = $this->actingAs($this->user)->get('/projects');
        $res->assertDontSee($projects->last()->name);
    }

    /**
     * @return void
     */
    public function test_non_logged_user_cannot_see_projects_list()
    {
        $res = $this->get('/projects');
        $res->assertStatus(302);
        $res->assertRedirect('/login');
    }

    public function test_logged_user_can_see_create_button()
    {
        $this->create_user(1);
        $res = $this->actingAs($this->user)->get('projects');
        $res->assertStatus(200);
        $res->assertSee('New Project');
    }

    /**
     * @return void
     */
    public function test_logged_user_can_access_new_project()
    {
        $this->create_user(1);
        $res = $this->actingAs($this->user)->get('/projects/create');
        $res->assertStatus(200);
        $res->assertSee('Save');
    }

    public function test_non_logged_user_cannot_access_new_project()
    {
        $res = $this->get('/projects/create');
        $res->assertStatus(302);
        $res->assertRedirect('/login');
    }

    /**
     * @return void
     */
    public function test_logged_user_can_create_new_project()
    {
        $this->create_user(1);
        $subject = Subject::factory()->create([
            'user_id' => $this->user->id
        ]);
        $data = [
            'user_id' => $this->user->id,
            'subject_id' => $subject->id,
            'name' => 'The new',
            'slug' => Str::slug('The new'),
            'description' => 'About all new post',
        ];
        $res = $this->actingAs($this->user)->post('/projects', $data);
        $res->assertRedirect('/projects');
        $this->assertDatabaseHas('projects', $data);
    }

    public function test_logged_user_can_access_edit_page()
    {
        $this->create_user(1);
        $project = Project::factory()->create(
            ['user_id' => $this->user->id]
        );

        $res = $this->actingAs($this->user)->get("projects/$project->slug/edit");
        $res->assertStatus(200);
        $res->assertSee($project->name);
        $res->assertSee($project->description);
    }

    /**
     * @return void
     */
    public function test_logged_user_can_update_project()
    {
        $this->withoutExceptionHandling();
        $this->create_user(1);
        $project = Project::factory()->create(
            ['user_id' => $this->user->id]
        );
        $subject = Subject::factory()->create([
            'user_id' => $this->user->id
        ]);
        $res = $this->actingAs($this->user)->patch("projects/$project->slug", [
            'id' => $project->id,
            'user_id' => $this->user->id,
            'subject_id' => $subject->id,
            'name' => $project->name,
            'slug' => $project->slug,
            'description' => $project->description
        ]);
        
        $res->assertStatus(302);
        $res->assertRedirect(route('projects.index'));
        $res->assertSessionHas(['success']);
    }

    /**
     * @return void
     */
    public function test_logged_user_can_view_edit_button_in_index_page()
    {
        $this->create_user(1);
        Project::factory(3)->create(
            ['user_id' => $this->user->id]
        );
        $res = $this->actingAs($this->user)->get("projects");
        $res->assertSee('Edit');
    }

    /**
     * @return void
     */
    public function test_logged_user_can_view_edit_button_in_show_page()
    {
        $this->create_user(1);
        $project = Project::factory()->create(
            ['user_id' => $this->user->id]
        );
        $res = $this->actingAs($this->user)->get("projects/$project->slug");
        $res->assertSee('Edit');
    }

    /**
     * @return void
     */
    public function test_logged_user_can_delete_project()
    {
        $this->create_user(1);
        $project = Project::factory()->create(
            ['user_id' => $this->user->id]
        );
        $this->assertEquals(1, $project->count());
        $res = $this->actingAs($this->user)->delete('projects/' . $project->slug);
        $res->assertRedirect('projects');
        $this->assertEquals(0, Project::count());
        $res->assertSessionHas('success');
    }
}
