<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Page;
use App\Models\User;
use App\Models\Image;
use App\Models\Project;
use App\Models\Section;
use App\Models\Subject;
use App\Models\RoleUser;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ProjectTest extends TestCase
{
	use RefreshDatabase, WithFaker;

	/**
	 * @var
	 */
	private $user;

	
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
		$subject = Subject::factory()->create([
			'user_id' => $this->user->id,
		]);
		$project = Project::factory()->create([
			'user_id' => $this->user->id,
			'subject_id' => $subject->id
		]);
		$res = $this->actingAs($this->user)->get('/projects');
		$res->assertStatus(200);
		$view = $res->viewData('projects');
		$this->assertEquals($project->name, $view->last()->name);
	}

	public function test_logged_user_cannot_see_seventh_project_from_list()
	{
		$this->create_user(1);
		$subject = Subject::factory()->create([
			'user_id' => $this->user->id,
		]);
		$project = Project::factory()->create([
			'user_id' => $this->user->id,
			'subject_id' => $subject->id
		]);
		
		$res = $this->actingAs($this->user)->get('/projects');
		$res->assertDontSee($project->first()->name);
	}

	/**
	 * Assert that first project displayed in second page 
	 * is last project recorded in database.
	 *
	 * @return void
	 */
	public function test_logged_user_can_see_paginate_projects_list()
	{
		$this->create_user(1);
		$subject = Subject::factory()->create([
			'user_id' => $this->user->id,
		]);
		$project = Project::factory(7)->create([
			'user_id' => $this->user->id,
			'subject_id' => $subject->id
		]);
		$res = $this->actingAs($this->user)->get('projects?page=2');
		$res->assertStatus(200);
		$view = $res->viewData('projects');
		
		$this->assertEquals($view->first()->name, $project->last()->name);
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

	public function test_guest_user_cannot_create_project()
	{
		$this->create_user(3);
		$res = $this->actingAs($this->user)->get('/projects/create');
		$res->assertStatus(403);
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

	public function test_logged_editor_user_can_create_new_project()
	{
		$this->create_user(2);
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
		$subject = Subject::factory()->create([
			'user_id' => $this->user->id,
		]);
		$project = Project::factory()->create([
			'user_id' => $this->user->id,
			'subject_id' => $subject->id
		]);
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
		$nameSub = $this->faker->text(30);
		$desSub =  $this->faker->paragraph(2, true);
		$subject = Subject::factory()->create([
				'id' => 1,
				'user_id' => $this->user->id,
				'name' => $nameSub,
				'slug' => Str::slug($nameSub),
				'description' => $desSub
		]);

		$project = Project::factory()->create([
			'user_id' => $this->user->id,
			'subject_id' => $subject->id
		]);

		$name = $this->faker->text(30);
		$des =  $this->faker->paragraph(2, true);
		$res = $this->actingAs($this->user)->patch("projects/$project->slug", [
			'user_id' => $this->user->id,
			'subject_id' => $subject->id,
			'name' => $name,
			'slug' => Str::slug($name),
			'description' => $des,
			'visibility' => 1
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
		$subject = Subject::factory()->create([
			'user_id' => $this->user->id,
		]);

		Project::factory()->create([
			'user_id' => $this->user->id,
			'subject_id' => $subject->id
		]);
		$res = $this->actingAs($this->user)->get("projects");
		$res->assertSee('Edit');
	}

	/**
	 * @return void
	 */
	public function test_logged_user_can_view_edit_button_in_show_page()
	{
		$this->create_user(1);
		$subject = Subject::factory()->create([
			'user_id' => $this->user->id,
		]);
		$project = Project::factory()->create([
			'user_id' => $this->user->id,
			'subject_id' => $subject->id
		]);
		$res = $this->actingAs($this->user)->get("projects/$project->slug");
		$res->assertSee('Edit');
	}

	/**
	 * @return void
	 */
	public function test_logged_user_can_view_delete_button_in_show_page()
	{
		$this->create_user(1);
		$subject = Subject::factory()->create([
			'user_id' => $this->user->id,
		]);
		$project = Project::factory()->create([
			'user_id' => $this->user->id,
			'subject_id' => $subject->id
		]);
		$res = $this->actingAs($this->user)->get("projects/$project->slug");
		$res->assertSee('Delete');
	}

	/**
	 * @return void
	 */
	public function test_logged_user_can_delete_project()
	{
		$this->create_user(1);
		$subject = Subject::factory()->create([
			'user_id' => $this->user->id,
		]);
		$project = Project::factory()->create([
			'user_id' => $this->user->id,
			'subject_id' => $subject->id
		]);
		$this->assertEquals(1, $project->count());
		$res = $this->actingAs($this->user)->delete('projects/' . $project->slug);
		$res->assertRedirect('projects');
		$this->assertEquals(0, Project::count());
		$res->assertSessionHas('success');
	}

	public function test_project_deleted_remove_sections_belongs_to_it()
	{
		$this->create_user(1);
		$subject = Subject::factory()->create([
			'user_id' => $this->user->id,
		]);
		$project = Project::factory()->create([
			'user_id' => $this->user->id,
			'subject_id' => $subject->id
		]);
		$section = Section::factory()->create([
			'project_id' => $project->id,
		]);
		$page = Page::factory()->create([
			'project_id' => $project->id,
			'section_id' => $section->id
		]);
		$nameSub = $this->faker->text(30);
		$desSub =  $this->faker->paragraph(2, true);
		$data = [
			'title' => $nameSub,
			'slug' => Str::slug($nameSub),
			'description' => $desSub
		];
		$pg = [
			'title' => 'The test',
			'content' => 'Blah blah',
			'page_type' => 'page',
			'created_by' => $this->user->id,
			'updated_by' => $this->user->id,
			'owned_by' => $this->user->id,
			'slug' => 'the-test'
		];
		$this->assertEquals(1, $project->count());
		$this->assertEquals(1, $section->count());
		$this->assertEquals(1, $page->count());
		$res = $this->actingAs($this->user)->delete('projects/' . $project->slug);
		$res->assertRedirect('projects');
		$this->assertEquals(0, Project::count());
		$this->assertDatabaseMissing('sections', $data);
		$this->assertDatabaseMissing('pages', $pg);
		$res->assertSessionHas('success');
	}

	public function test_logged_user_can_upload_cover_image()
	{
		$this->create_user(1);
		Storage::fake('public');
		Storage::makeDirectory($this->user->id);
		$file = UploadedFile::fake()->image('logo.jpg', 500, 450)->size(500);
		
		$image = Image::create([
			'name' => $file->hashName(),
			'url' => config('app.url') . "/storage/uploads/" . $this->user->id . "/" . $file->hashName(),
			'path' => "uploads/" . $this->user->id . "/" . $file->hashName(),
			'created_by' => $this->user->id,
			'updated_by' => $this->user->id,
			'type' => 'cover'
		]);
		$subject = Subject::factory()->create([
			'user_id' => $this->user->id
		]);
		
		$nameProject = $this->faker->sentence(3, true); 
		$res = $this->actingAs($this->user)->post('projects/', [
			'user_id' => $this->user->id,
			'name' => $nameProject,
			'slug' => Str::slug($nameProject),
			'featured' => $file,
			'subject_id' => $subject->id,
			'image_id' => $image->id
		]);
		
		Storage::disk('public')->assertExists("uploads/" . $this->user->id . "/" . $file->hashName());
		$this->assertDatabaseHas('images', [
			'name' => $file->hashName(),
			'url' => config('app.url') . "/storage/uploads/" . $this->user->id . "/" . $file->hashName(),
			'path' => "uploads/" . $this->user->id . "/" . $file->hashName(),
			'created_by' => $this->user->id,
			'updated_by' => $this->user->id,
			'type' => 'cover'
		]);
		$res->assertStatus(302);
		$res->assertRedirect('projects');
	}

	/**
	 * Update cover image and delte old uploaded file.
	 *
	 * @return void
	 */
	public function test_logged_user_can_update_upload_cover_image()
	{
		$this->create_user(1);
		Storage::fake('public');
		Storage::makeDirectory($this->user->id);
		$file = UploadedFile::fake()->image('logo.jpg', 500, 450)->size(500);
		$newFile = UploadedFile::fake()->image('avatar.png', 300, 250)->size(400);
		
		$image = Image::create([
			'name' => $file->hashName(),
			'url' => config('app.url') . "/storage/uploads/" . $this->user->id . "/" . $file->hashName(),
			'path' => "uploads/" . $this->user->id . "/" . $file->hashName(),
			'created_by' => $this->user->id,
			'updated_by' => $this->user->id,
			'type' => 'cover'
		]);
		$subject = Subject::factory()->create([
			'user_id' => $this->user->id
		]);
		$nameProject = $this->faker->sentence(3, true); 
		$project = Project::create([
			'user_id' => $this->user->id,
			'subject_id' => $subject->id,
			'name' => $nameProject,
			'slug' => Str::slug($nameProject),
			'image_id' => $image->id
		]);

		$res = $this->actingAs($this->user)->patch('projects/' . $project->slug, [
			'user_id' => $this->user->id,
			'subject_id' => $subject->id,
			'name' => $nameProject,
			'slug' => Str::slug($nameProject),
			'featured' => $newFile
		]);
		Storage::delete($file);
		
		Storage::disk('public')->assertExists("uploads/" . $this->user->id . "/" . $newFile->hashName());
	
		$res->assertStatus(302);
		$res->assertRedirect('projects');
	}
}
