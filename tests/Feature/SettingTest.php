<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\RoleUser;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SettingTest extends TestCase
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
}
