<?php

namespace Tests\Feature;

use Carbon\Carbon;
use App\Models\Tag;
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

class PageTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $user;

    private function create_user(int $role)
    {
        $this->user = User::factory()->create();
        RoleUser::create([
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

    public function test_logged_user_can_access_show_page()
    {
        $page = Page::create($this->createPage(1));   
        $res = $this->actingAs($this->user)->get('pages/' . $page->slug);
        $res->assertStatus(200);
    }

    public function test_logged_user_can_access_create_page()
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
        $res = $this->actingAs($this->user)->get("$project->slug/$section->slug/pages/create");
        $res->assertStatus(200);
    }

    public function test_logged_user_can_create_page()
    {
        $page = $this->createPage(1);
        $res = $this->actingAs($this->user)->post('pages/', $page);
        $res->assertRedirect(route('pages.show', $page['slug']));
        $res->assertSessionHas('success');
        //$this->assertDatabaseHas('pages', $pg);
    }

    public function test_logged_editor_user_can_create_page()
    {
        $pg = $this->createPage(2);
        $res = $this->actingAs($this->user)->post('pages/', $pg);
        $res->assertRedirect(route('pages.show', $pg['slug']));
        $res->assertSessionHas('success');
    }

    public function test_logged_guest_user_cannot_create_page()
    {
        $this->create_user(3);
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
        
        $res = $this->actingAs($this->user)->get(route('pages.create', [$project->slug, $section->slug]));
        $res->assertStatus(403);
    }

    public function test_logged_user_can_view_edit_page()
    {
        $pg = $this->createPage(1); 
        $page = Page::create($pg);
        $res = $this->actingAs($this->user)->get('pages/' . $page->slug);
        $res->assertStatus(200);
        $res->assertSee($page->title);
    }

    public function test_logged_user_can_update_page()
    {
        $page = Page::create($this->createPage(1));
        $title = $this->faker->sentence(2,true);
        $slug = Str::slug($title);
        $content = $this->faker->paragraph(3, true);
        $res = $this->actingAs($this->user)->put("pages/" . $page->slug, [ 
            'title' => $title,
			'content' => $content,
			'page_type' => 'page',
			'created_by' => $page->created_by,
            'updated_by' => $page->updated_by,
            'owned_by' => $page->owned_by,
            'project_id' => $page->project_id,
            'section_id' => $page->section_id,
			'slug' => $slug,
        ]);
        
        $res->assertStatus(302);
        $res->assertRedirect(route('pages.show', $slug));
        $res->assertSessionHas('success');
    }

    public function test_logged_user_can_access_delete_page()
    {
        $page = Page::create($this->createPage(1));
        $res = $this->actingAs($this->user)->get(route('pages.destroy', $page->slug));
        $res->assertSee('Confirm');
        $res->assertSee('Cancel');
        $res->assertSee($page->title);
    }

    public function test_logged_editor_user_can_access_delete_page()
    {
        $page = Page::create($this->createPage(2));
        $res = $this->actingAs($this->user)->get(route('pages.destroy', $page->slug));
        $res->assertSee('Confirm');
        $res->assertSee('Cancel');
        $res->assertSee($page->title);
    }

    public function test_logged_user_can_delete_page()
    {
        $page = Page::create($this->createPage(1));
        $res = $this->actingAs($this->user)->delete('pages/' . $page->slug);
        $res->assertRedirect(route('sections.show', [$page->project->slug, $page->section->slug]));
        $res->assertSessionHas('success');
    }

    public function test_logged_editor_user_can_delete_page()
    {
        $page = Page::create($this->createPage(2));
        $res = $this->actingAs($this->user)->delete('pages/' . $page->slug);
        $res->assertRedirect(route('sections.show', [$page->project->slug, $page->section->slug]));
        $res->assertSessionHas('success');
    }

    /**
	 * @return void
	 */
	public function test_logged_user_can_add_tag_to_page()
	{
		$this->create_user(1);
		$tagName = $this->faker->word;
		$id = $this->faker->randomDigitNot(0);
        $title = $this->faker->sentence(2,true);
        $content = $this->faker->paragraph(3, true);
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
		$tag = [
            'user_id' => $this->user->id,
			'page_id' => $id,
			'page_type' => 'page',
			'name' => $tagName
		];
		Tag::create($tag);
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
        $res = $this->actingAs($this->user)->post('pages/', $pg);
        $res->assertRedirect(route('pages.show', Str::slug($title)));
        $res->assertSessionHas('success');
		$this->assertDatabaseHas('tags', $tag);
		
	}

	public function test_logged_user_can_update_tags_in_page()
	{
        $this->withoutExceptionHandling();
		//$this->create_user(1);
		$page = Page::create($this->createPage(1));
        $title = $this->faker->sentence(2,true);
        $slug = Str::slug($title);
        $content = $this->faker->paragraph(3, true);
        $tagName = $this->faker->word;
		$id = $this->faker->randomDigitNot(0);
        $tag = [
            'user_id' => $this->user->id,
			'page_id' => $page->id,
			'page_type' => 'page',
			'name' => $tagName
		];
        $newTag = $this->faker->word;
		$tags = Tag::create($tag);
        $res = $this->actingAs($this->user)->put("pages/" . $page->slug, [ 
            'title' => $title,
			'content' => $content,
			'page_type' => 'page',
			'created_by' => $page->created_by,
            'updated_by' => $page->updated_by,
            'owned_by' => $page->owned_by,
            'project_id' => $page->project_id,
            'section_id' => $page->section_id,
			'slug' => $slug,
            'page_id' => $page->id,
			'page_type' => 'page',
			'name' => $newTag
        ]);
        $tags->update([
            'page_id' => $page->id,
			'page_type' => 'page',
			'name' => $newTag
        ]);
        
        $res->assertStatus(302);
        $res->assertRedirect(route('pages.show', $slug));
        $res->assertSessionHas('success');
        $this->assertDatabaseHas('tags', [
            'user_id' => $this->user->id,
            'page_id' => $page->id,
			'page_type' => 'page',
			'name' => $newTag
        ]);
	}

	public function test_logged_user_can_delete_tag_in_page()
	{
		$page = $this->createPage(1);
		Page::create($page);
		$tagName = $this->faker->word;
		$updateName = $this->faker->word;
		$id = $this->faker->randomDigitNot(0);
		$tag = [
            'user_id' => $this->user->id,
			'page_id' => $id,
			'page_type' => 'subject',
			'name' => $tagName
		];
		$newTag = Tag::create($tag);
		$this->assertEquals(1, $newTag->count());
		$res = $this->actingAs($this->user)->delete('/pages/' . $page['slug']);
		
		$res->assertStatus(302);
		$res->assertSessionHas('success');
		$this->assertEquals(1, $newTag->count());
	}


   
}
