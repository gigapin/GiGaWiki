<?php

namespace Tests\Feature;

use App\Models\Tag;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Subject;
use App\Models\RoleUser;
use App\Actions\TagAction;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagTest extends TestCase
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

	public function test_logged_user_can_see_all_tags()
	{
		$this->create_user(1);
		$subject = Subject::factory()->create([
			'user_id' => $this->user->id
		]);
		$project = Project::factory()->create([
			'user_id' => $this->user->id,
			'subject_id' => $subject->id
		]);
		$tag = new TagAction();
		$tag->createTag($this->user->id, 'laravel', $project, 'project');
		$this->assertDatabaseHas('tags', [
			'user_id' => $this->user->id,
			'name' => 'laravel',
			'page_id' => $project->id,
			'page_type' => 'project'
		]);
		$res = $this->actingAs($this->user)->get('tags', [
			'user_id' => $this->user->id,
			'name' => 'laravel',
			'page_id' => $project->id,
			'page_type' => 'project'
		]);
		$res->assertStatus(200);
	}

	public function test_logged_user_can_see_page_has_tag()
	{
		$this->create_user(1);
		$subject = Subject::factory()->create([
			'user_id' => $this->user->id
		]);
		$project = Project::factory()->create([
			'user_id' => $this->user->id,
			'subject_id' => $subject->id
		]);
		$tag = new TagAction();
		$tag->createTag($this->user->id, 'laravel', $project, 'project');
		$this->assertDatabaseHas('tags', [
			'user_id' => $this->user->id,
			'name' => 'laravel',
			'page_id' => $project->id,
			'page_type' => 'project'
		]);
		$res = $this->actingAs($this->user)->get('projects/' . $project->slug);
		$res->assertStatus(200);
		
	}

	public function test_logged_user_can_delete_tag()
	{
		$this->create_user(1);
		$subject = Subject::factory()->create([
			'user_id' => $this->user->id
		]);
		$project = Project::factory()->create([
			'user_id' => $this->user->id,
			'subject_id' => $subject->id
		]);
		$tag = new TagAction();
		$tags = $tag->createTag($this->user->id, 'laravel', $project, 'project');
		
		$this->assertEquals(1, $tags->count());

		$res = $this->actingAs($this->user)->delete('tags/' . $tags->id);
		$this->assertEquals(0, Tag::count());
		$res->assertRedirect();
	}

    
}
