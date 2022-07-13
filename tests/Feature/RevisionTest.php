<?php

namespace Tests\Feature;

use App\Models\Page;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Revision;
use App\Models\Section;
use App\Models\Subject;
use App\Models\RoleUser;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RevisionTest extends TestCase
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

    private function createPage(int $role): array
    {
        $this->create_user($role);
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
        $pg = [
			'title' => $title,
			'content' => $content,
			'page_type' => 'page',
			'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
            'owned_by' => $this->user->id,
            'project_id' => $project->id,
            'section_id' => $section->id,
			'slug' => Str::slug($title)
		];

        return $pg;
    }

    public function test_logged_user_can_see_all_revision_about_a_page()
    {
        $pg = $this->createPage(1);
        $page = Page::create($pg);
        
        $revision = [
            'project_id' => $page->project_id,
            'section_id' => $page->section_id,
            'page_id' => $page->id,
            'title' => $page->title,
            'content' => $page->content,
            'created_by' => $page->created_by,
            'slug' => $page->slug,
            'revision_number' => 1
        ];
        Revision::create($revision);

        $res = $this->actingAs($this->user)->get("$page->project->slug/page/$page->id/revision", $revision);
        $res->assertSee($page->title);
        $this->assertDatabaseHas('revisions', $revision);
    }

    public function test_logged_user_can_see_preview_about_revision()
    {
        $pg = $this->createPage(1);
        $page = Page::create($pg);
        
        $revision = [
            'project_id' => $page->project_id,
            'section_id' => $page->section_id,
            'page_id' => $page->id,
            'title' => $page->title,
            'content' => $page->content,
            'created_by' => $page->created_by,
            'slug' => $page->slug,
            'revision_number' => 1
        ];
        $preview = Revision::create($revision);

        $res = $this->actingAs($this->user)->get("$page->project->slug/$page->slug/revision/preview/$preview->id", $pg);
        $res->assertSee($page->title);
        $res->assertSee($page->content);        

    }

    public function test_logged_user_can_see_restore_about_revision()
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
        $title = $this->faker->sentence(2,true);
        $content = $this->faker->paragraph(3, true);
        $pg = [
            'title' => $title,
			'content' => $content,
			'page_type' => 'page',
			'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
            'owned_by' => $this->user->id,
            'project_id' => $project->id,
            'section_id' => $section->id,
			'slug' => Str::slug($title),
        ];
        $page = Page::create($pg);
        
        $revision = [
            'project_id' => $page->project_id,
            'section_id' => $page->section_id,
            'page_id' => $page->id,
            'title' => $page->title,
            'content' => $page->content,
            'created_by' => $page->created_by,
            'slug' => $page->slug,
            'revision_number' => 0,
        ];
        $rev = Revision::create($revision);

        $res = $this->actingAs($this->user)->get("$page->project->slug/$page->slug/revision/restore/$rev->id");
        
        $page->update([
            'title' => $title,
			'content' => $content,
			'page_type' => 'page',
			'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
            'owned_by' => $this->user->id,
            'project_id' => $project->id,
            'section_id' => $section->id,
			'slug' => Str::slug($title),
            'current_revision' => $rev->id
        ]);
        $res->assertSee($page->title);
        $res->assertSee($page->content);  
        $this->assertDatabaseHas('pages', [
            'title' => $title,
			'content' => $content,
			'page_type' => 'page',
			'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
            'owned_by' => $this->user->id,
            'project_id' => $project->id,
            'section_id' => $section->id,
			'slug' => Str::slug($title),
            'current_revision' => $rev->id
        ]) ;  
        
    }

    
}
