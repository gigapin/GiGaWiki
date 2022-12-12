<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Page;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Section;
use App\Models\Subject;
use App\Models\RoleUser;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
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

    public function test_logged_user_can_create_comment_in_subject()
    {
        $this->create_user(1);
        $body = $this->faker->sentence(2, true);
        $subject = Subject::factory()->create([
            'user_id' => $this->user->id
        ]);
        $comment = [
            'user_id' => $this->user->id,
            'page_id' => $subject->id,
            'page_type' => 'subject',
            'body' => $body
        ];
        $res = $this->actingAs($this->user)->post("subjects/$subject->slug/comments", $comment);
        $res->assertStatus(302);
        $this->assertDatabaseHas('comments', $comment);
    }

    public function test_logged_user_can_create_comment_in_project()
    {
        $this->create_user(1);
        $body = $this->faker->sentence(2, true);
        $subject = Subject::factory()->create([
            'user_id' => $this->user->id
        ]);
        $project = Project::factory()->create([
            'user_id' => $this->user->id,
            'subject_id' => $subject->id
        ]);
        $comment = [
            'user_id' => $this->user->id,
            'page_id' => $subject->id,
            'page_type' => 'project',
            'body' => $body
        ];
        $res = $this->actingAs($this->user)->post("projects/$project->slug/comments", $comment);
        $res->assertStatus(302);
        $this->assertDatabaseHas('comments', $comment);
    }

    public function test_logged_user_can_create_comment_in_section()
    {
        $this->create_user(1);
        $body = $this->faker->sentence(2, true);
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
        $comment = [
            'user_id' => $this->user->id,
            'page_id' => $subject->id,
            'page_type' => 'section',
            'body' => $body
        ];
        $res = $this->actingAs($this->user)->post("sections/$section->slug/comments", $comment);
        $res->assertStatus(302);
        $this->assertDatabaseHas('comments', $comment);
    }

    public function test_logged_user_can_create_comment_in_page()
    {
        $this->create_user(1);
        $body = $this->faker->sentence(2, true);
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
        $title = $this->faker->sentence(2,true);
        $content = $this->faker->paragraph(3, true);
        $slug = Str::slug($title);
        $pg = [
			'title' => $title,
			'content' => $content,
			'page_type' => 'page',
			'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
            'owned_by' => $this->user->id,
            'project_id' => $project->id,
            'section_id' => $section->id,
			'slug' => $slug
		];
        $page = Page::create($pg);
        $comment = [
            'user_id' => $this->user->id,
            'page_id' => $page->id,
            'page_type' => 'page',
            'body' => $body
        ];
        $res = $this->actingAs($this->user)->post("pages/$page->slug/comments", $comment);
        $res->assertStatus(302);
        $this->assertDatabaseHas('comments', $comment);
    }

    public function test_logged_user_can_update_comment()
    {
        $this->create_user(1);
        $body = $this->faker->sentence(2, true);
        $subject = Subject::factory()->create([
            'user_id' => $this->user->id
        ]);
        $commentCreate = Comment::create([
            'user_id' => $this->user->id,
            'page_id' => $subject->id,
            'page_type' => 'subject',
            'body' => "Good"

        ]);
        $comment = [
            'user_id' => $this->user->id,
            'page_id' => $subject->id,
            'page_type' => 'subject',
            'body' => $body
        ];
        $res = $this->actingAs($this->user)->put("subjects/$subject->slug/comments/$commentCreate->id", $comment);
        $res->assertStatus(302);
        $this->assertDatabaseHas('comments', $comment);
    }

    public function test_logged_user_can_write_a_reply_to_comment()
    {
        $this->create_user(1);
        $body = $this->faker->sentence(2, true);
        $subject = Subject::factory()->create([
            'user_id' => $this->user->id
        ]);
        $commentCreate = Comment::create([
            'user_id' => $this->user->id,
            'page_id' => $subject->id,
            'page_type' => 'subject',
            'body' => "Good"
        ]);
        $comment = [
            'user_id' => $this->user->id,
            'page_id' => $subject->id,
            'page_type' => 'subject',
            'body' => $body,
            'parent_id' => $commentCreate->id
        ];
        $res = $this->actingAs($this->user)->post("subjects/$subject->slug/comments/$commentCreate->id", $comment);
        $res->assertStatus(302);
        $this->assertDatabaseHas('comments', $comment);
    }

    public function test_logged_user_can_delete_a_comment()
    {
        $this->create_user(1);
        $body = $this->faker->sentence(2, true);
        $subject = Subject::factory()->create([
            'user_id' => $this->user->id
        ]);
        $commentCreate = Comment::create([
            'user_id' => $this->user->id,
            'page_id' => $subject->id,
            'page_type' => 'subject',
            'body' => "Good"
        ]);
        $this->assertEquals(1, $commentCreate->count());
        $res = $this->actingAs($this->user)->delete("subjects/$subject->slug/comments/$commentCreate->id");
        $res->assertStatus(302);
        $this->assertEquals(0, Comment::count());
    }
}
