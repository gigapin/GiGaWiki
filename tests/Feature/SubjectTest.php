<?php

namespace Tests\Feature;

use App\Models\Tag;
use Tests\TestCase;
use App\Models\User;
use App\Models\Image;
use App\Models\Subject;
use App\Models\Activity;
use App\Models\RoleUser;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class SubjectTest extends TestCase
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
		
		$nameSubject = $this->faker->sentence(3, true); 
		$res = $this->actingAs($this->user)->post('subjects/', [
			'user_id' => $this->user->id,
			'name' => $nameSubject,
			'slug' => Str::slug($nameSubject),
			'featured' => $file
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
		$res->assertRedirect('subjects');
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

		$nameSubject = $this->faker->sentence(3, true); 
		$subject = Subject::create([
			'user_id' => $this->user->id,
			'name' => $nameSubject,
			'slug' => Str::slug($nameSubject),
			'image_id' => $image->id
		]);

		$res = $this->actingAs($this->user)->patch('subjects/' . $subject->slug, [
			'user_id' => $this->user->id,
			'name' => $nameSubject,
			'slug' => Str::slug($nameSubject),
			'featured' => $newFile
		]);
		Storage::delete($file);
		
		Storage::disk('public')->assertExists("uploads/" . $this->user->id . "/" . $newFile->hashName());
	
		$res->assertStatus(302);
		$res->assertRedirect('subjects');
	}

	/**
	 * A basic feature test example.
	 *
	 * @return void
	 */
	public function test_non_logged_user_cannot_access_subject_page()
	{
		$response = $this->get('/subjects');
		$response->assertStatus(302);
		$response->assertRedirect('/login');
	}

	/**
	 * @return void
	 */
	public function test_logged_user_can_see_message_no_subjects_created()
	{
		$this->create_user(1);
		$res = $this->actingAs($this->user)->get('/subjects');
		$res->assertOk();
		$res->assertSee('No data available');
	}

	/**
	 * @return void
	 */
	public function test_logged_user_can_see_subjects_list()
	{
		$this->create_user(1);
		$subjects = Subject::factory()->create([
			'user_id' => $this->user->id
		]);
		$res = $this->actingAs($this->user)->get('/subjects');
		$res->assertStatus(200);
		$view = $res->viewData('bodies');
		$this->assertEquals($view->first()->name, $subjects->first()->name);
	}

	public function test_logged_user_can_see_paginate_subjects_list()
	{
		$this->create_user(1);
		$subjects = Subject::factory(7)->create([
			'user_id' => $this->user->id
		]);
		$res = $this->actingAs($this->user)->get('subjects?page=2');
		$res->assertStatus(200);
		$view = $res->viewData('bodies');
		$this->assertEquals($view->first()->name, $subjects->last()->name);
	}

	/**
	 * Test pagination.
	 *
	 * @return void
	 */
	public function test_logged_user_cannot_see_seventh_subject_listed()
	{
		$this->create_user(1);
		$subjects = Subject::factory(7)->create();
		$res = $this->actingAs($this->user)->get('/subjects');
		$res->assertStatus(200);
		$res->assertDontSee($subjects->last()->name);
	}

	/**
	 * @return void
	 */
	public function test_logged_user_can_see_create_subject_button()
	{
		$this->create_user(1);
		$res = $this->actingAs($this->user)->get('/subjects');
		$res->assertStatus(200);
		$res->assertSee('New Subject');
	}

	/**
	 * @return void
	 */
	public function test_logged_editor_user_cannot_see_create_subject_button()
	{
		$this->create_user(2);
		$res = $this->actingAs($this->user)->get('/subjects');
		$res->assertDontSee('New Subject');
	}

	/**
	 * @return void
	 */
	public function test_logged_user_cannot_access_create_subject_page()
	{
		$this->create_user(2);
		$res = $this->actingAs($this->user)->get('/subjects/create');
		$res->assertStatus(403);
	}

	/**
	 * @return void
	 */
	public function test_logged_user_can_access_create_subject_page()
	{
		$this->create_user(1);
		$res = $this->actingAs($this->user)->get('/subjects/create');
		$res->assertStatus(200);
		$res->assertSeeText('Save');
	}

	/**
	 * @return void
	 */
	public function test_logged_user_can_create_subject()
	{
		$this->create_user(1);
		Storage::fake('public');
		Storage::makeDirectory($this->user->id);
		$file = UploadedFile::fake()->image('logo.jpg', 500, 450)->size(500);
		$name = $this->faker->sentence($nbWords = 3, true);
		$description = $this->faker->paragraph(2, true);
		$image = Image::create([
			'name' => $file->hashName(),
			'url' => config('app.url') . "/storage/uploads/" . $this->user->id . "/" . $file->hashName(),
			'path' => "uploads/" . $this->user->id . "/" . $file->hashName(),
			'created_by' => $this->user->id,
			'updated_by' => $this->user->id,
			'type' => 'cover'
		]);
		
		$data = [
			'user_id' => $this->user->id,
			'name' => $name,
			'slug' => Str::slug($name),
			'description' => $description,
			'featured' => $file,
			
		];

		$res = $this->actingAs($this->user)->post('/subjects', $data);
		Storage::disk('public')->assertExists("uploads/" . $this->user->id . "/" . $file->hashName());
		$res->assertRedirect('/subjects');
		$res->assertSessionHas('success');
	}

	/**
	 * @return void
	 */
	public function test_logged_editor_user_cannot_create_subject()
	{
		$this->create_user(2);
		$name = $this->faker->sentence($nbWords = 3, true);
		$description = $this->faker->paragraph(2, true);
		$data = [
			'user_id' => $this->user->id,
			'name' => $name,
			'slug' => Str::slug($name),
			'description' => $description,
		];

		$res = $this->actingAs($this->user)->post('/subjects', $data);
		$res->assertStatus(403);
	}

	/**
	 * @return void
	 */
	public function test_logged_user_can_add_tag_to_subject()
	{
		$this->create_user(1);
		$tagName = $this->faker->word;
		$id = $this->faker->randomDigitNot(0);
		$tag = [
			'user_id' => $this->user->id,
			'page_id' => $id,
			'page_type' => 'subject',
			'name' => $tagName
		];
		$activity = [
			'user_id' => $this->user->id,
			'type' => 'created',
			'page_id' => $id,
			'page_type' => 'subject',
			'details' => '',
			'ip' => "127.0.0.1"
		];
		Tag::create($tag);
		Activity::create($activity);

		$res = $this->actingAs($this->user)->post('/subjects', $tag);
		$res->assertRedirect('/subjects');
		$res->assertSessionHas('success');
		$this->assertDatabaseHas('tags', $tag);
		$this->assertDatabaseHas('activities', $activity);
	}

	public function test_logged_editor_user_cannot_add_tag_to_subject()
	{
		$this->create_user(2);
		$tagName = $this->faker->word;
		$id = $this->faker->randomDigitNot(0);
		$tag = [
			'user_id' => $this->user->id,
			'page_id' => $id,
			'page_type' => 'subject',
			'name' => $tagName
		];
		
		Tag::create($tag);
	
		$res = $this->actingAs($this->user)->post('/subjects', $tag);
		$res->assertStatus(403);
	}

	public function test_logged_user_can_update_tags_in_subjects()
	{
		$this->create_user(1);
		$subject = Subject::factory()->create([
			'user_id' => $this->user->id
		]);
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
		$res = $this->actingAs($this->user)->patch('/subjects/' . $subject->slug, [
			'user_id' => $this->user->id,
			'page_id' => $id,
			'page_type' => 'subject',
			'name' => $updateName
		]);
		$newTag->update([
			'page_id' => $id,
			'page_type' => 'subject',
			'name' => $updateName
		]);
		$res->assertRedirect('subjects');
		$res->assertSessionHas('success');
		$this->assertDatabaseHas('tags', [
			'page_id' => $id,
			'page_type' => 'subject',
			'name' => $updateName
		]);
	}

	public function test_logged_user_can_delete_tag_in_subject()
	{
		$this->create_user(1);
		$subject = Subject::factory()->create([
			'user_id' => $this->user->id
		]);
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
		$res = $this->actingAs($this->user)->delete('/subjects/' . $subject->slug, [
			'id' => $id
		]);
		$newTag->delete([
			'id' => $id
		]);
		$res->assertRedirect('subjects');
		$res->assertSessionHas('success');
		$this->assertEquals(0, Tag::count());
	}

	public function test_logged_user_can_view_subject()
	{
		$this->create_user(1);
		$subject = Subject::factory()->create([
			'user_id' => $this->user->id
		]);
		$res = $this->actingAs($this->user)->get('subjects/' . $subject->slug);
		$res->assertstatus(200);
		$res->assertSee($subject->name);
	}

	/**
	 * @return void
	 */
	public function test_logged_user_can_access_edit_page()
	{
		$this->create_user(1);
		$subject = Subject::factory()->create(
			['user_id' => $this->user->id]
		);

		$res = $this->actingAs($this->user)->get("subjects/$subject->slug/edit");
		$res->assertStatus(200);
		$res->assertSee($subject->name);
		$res->assertSee($subject->description);
	}

	/**
	 * @return void
	 */
	public function test_logged_editor_user_cannot_access_edit_page()
	{
		$this->create_user(2);
		$subject = Subject::factory()->create(
			['user_id' => $this->user->id]
		);
		$res = $this->actingAs($this->user)->get("subjects/$subject->slug/edit");
		$res->assertStatus(403);
	}

	/**
	 * @return void
	 */
	public function test_logged_user_can_update_subject()
	{
		$this->create_user(1);
		$subject = Subject::factory()->create(
			['user_id' => $this->user->id]
		);
		$name = $this->faker->text(30);
		$des =  $this->faker->paragraph(2, true);
		$res = $this->actingAs($this->user)->patch("subjects/$subject->slug", [
			'user_id' => $this->user->id,
			'name' => $name,
			'slug' => Str::slug($name),
			'description' => $des
		]);
		$res->assertStatus(302);
		$res->assertRedirect('subjects');
		$res->assertSessionHas(['success']);
	}

	/**
	 * @return void
	 */
	public function test_logged_user_cannot_update_subject()
	{
		$this->create_user(2);
		$subject = Subject::factory()->create(
			['user_id' => $this->user->id]
		);
		$name = $this->faker->text(30);
		$des =  $this->faker->paragraph(2, true);
		$res = $this->actingAs($this->user)->patch("subjects/$subject->slug", [
			'user_id' => $this->user->id,
			'name' => $name,
			'slug' => Str::slug($name),
			'description' => $des
		]);
		$res->assertStatus(403);
	}

	/**
	 * @return void
	 */
	public function test_logged_user_can_view_edit_button_in_index_page()
	{
		$this->create_user(1);
		Subject::factory(3)->create(
			['user_id' => $this->user->id]
		);
		$res = $this->actingAs($this->user)->get("subjects");
		$res->assertSee('Edit');
	}

	/**
	 * @return void
	 */
	public function test_logged_user_can_view_edit_button_in_show_page()
	{
		$this->create_user(1);
		$subject = Subject::factory()->create(
			['user_id' => $this->user->id]
		);
		$res = $this->actingAs($this->user)->get("subjects/$subject->slug");
		$res->assertSee('Edit');
	}

	/**
	 * @return void
	 */
	public function test_logged_user_cannot_view_edit_button_in_index_page()
	{
		$this->create_user(2);
		Subject::factory(3)->create(
			['user_id' => $this->user->id]
		);
		$res = $this->actingAs($this->user)->get("subjects");
		$res->assertDontSee('Edit');
	}

	/**
	 * @return void
	 */
	public function test_logged_user_cannot_view_edit_button_in_show_page()
	{
		$this->create_user(2);
		$subject = Subject::factory()->create([
			'user_id' => $this->user->id
		]);
		$res = $this->actingAs($this->user)->get("subjects/$subject->slug");
		$res->assertDontSee('Edit');
	}

	/**
	 * @return void
	 */
	public function test_logged_user_can_delete_subject()
	{
		$this->create_user(1);
		$subject = Subject::factory()->create([
			'user_id' => $this->user->id
		]);
		$this->assertEquals(1, $subject->count());
		$res = $this->actingAs($this->user)->delete('subjects/' . $subject->slug);
		$res->assertRedirect('subjects');
		$this->assertEquals(0, Subject::count());
		$res->assertSessionHas('success');
	}

	public function test_logged_user_can_delete_subject_with_cover_image()
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
		$nameSubject = $this->faker->sentence(2, true);
		$slug = Str::slug($nameSubject);

		$this->actingAs($this->user)->post('subjects/', [
			'user_id' => $this->user->id,
			'name' => $nameSubject,
			'slug' => $slug,
			'featured' => $file
		]);
		
		Storage::disk('public')->assertExists("uploads/" . $this->user->id . "/" . $file->hashName());

		$res = $this->actingAs($this->user)->delete('subjects/' . $slug);
		Storage::disk('public')->assertMissing($file);
		$res->assertRedirect('subjects');
		$res->assertSessionHas('success');
	}

	/**
	 * @return void
	 */
	public function test_editor_logged_user_cannot_delete_subject()
	{
		$this->create_user(2);
		$subject = Subject::factory()->create(
			['user_id' => $this->user->id]
		);
		$this->assertEquals(1, $subject->count());
		$res = $this->actingAs($this->user)->delete('subjects/' . $subject->slug);
		$res->assertStatus(403);
	}

	/**
	 * @return void
	 */
	public function test_logged_user_can_view_delete_button_in_index_page()
	{
		$this->create_user(1);
		Subject::factory(3)->create(
			['user_id' => $this->user->id]
		);
		$res = $this->actingAs($this->user)->get("subjects");
		$res->assertSee('Delete');
	}

	/**
	 * @return void
	 */
	public function test_logged_user_can_view_delete_button_in_show_page()
	{
		$this->create_user(1);
		$subject = Subject::factory()->create(
			['user_id' => $this->user->id]
		);
		$res = $this->actingAs($this->user)->get("subjects/$subject->slug");
		$res->assertSee('Delete');
	}

	/**
	 * @return void
	 */
	public function test_logged_user_cannot_view_delete_button_in_index_page()
	{
		$this->create_user(2);
		Subject::factory(3)->create(
			['user_id' => $this->user->id]
		);
		$res = $this->actingAs($this->user)->get("subjects");
		$res->assertDontSee('Delete');
	}

	/**
	 * @return void
	 */
	public function test_logged_user_cannot_view_delete_button_in_show_page()
	{
		$this->create_user(2);
		$subject = Subject::factory()->create(
			['user_id' => $this->user->id]
		);
		$res = $this->actingAs($this->user)->get("subjects/$subject->slug");
		$res->assertDontSee('Delete');
	}
}
