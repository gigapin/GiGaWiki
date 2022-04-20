<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Subject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\User;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    /**
     * Creating a faker user.
     *
     * @return void
     */
    private function create_user()
    {
        $this->user = User::factory()->create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'slug' => 'admin'
        ]);
    }

    /**
     * A user logged can see a message when no activity has been created.
     *
     * @return void
     */
    /*public function test_user_can_see_message_about_empty_projects_list()
    {
        $this->create_user();
        $res = $this->actingAs($this->user)->get('/dashboard');
        $res->assertStatus(200);
        $res->assertDontSee('No activity yet');

    }*/

    public function test_user_can_see_projects_list()
    {
        // Create an user
        $this->create_user();
        // Create a project
        $projects = Project::create([
            'user_id' => $this->user->id,
            'subject_id' => 1,
            'name' => 'Test',
            'slug' => Str::slug('Test'),
            'description' => 'Post or test'
        ]);
        // User logged access to page
        $res = $this->actingAs($this->user)->get('/dashboard');
        // Page loaded correctly
        $res->assertStatus(200);
        // Get displayed data.
        $view = $res->viewData('project_all');
        // Check if data created are equals to data showed within page.
        $this->assertEquals($projects->name, $view->first()->name);
    }

    public function test_user_can_access_create_project_page()
    {
        $this->create_user();
        $res = $this->actingAs($this->user)->get('/dashboard');
        // Page loaded correctly
        $res->assertStatus(200);
        $res->assertSee('New Project');

    }

}
