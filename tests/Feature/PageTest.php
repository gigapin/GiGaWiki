<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\RoleUser;
use App\Models\Page;
use App\Models\Project;
use App\Models\Section;
use Illuminate\Support\Str;
use Carbon\Carbon;

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

    public function test_logged_user_can_access_show_page()
    {
        $this->create_user(1);
        $page = Page::factory()->create([
            'created_by' => $this->user->id
        ]);
        $res = $this->actingAs($this->user)->get('pages/' . $page->slug);
        $res->assertStatus(200);
    }

   
}
