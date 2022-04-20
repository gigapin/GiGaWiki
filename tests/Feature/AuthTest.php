<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Redirect to dashboard for user correctly logged.
     *
     * @return void
     */
    public function test_access_app_single_user()
    {
        $user = User::factory()->create([
            'email' => 'user@giganotes.test',
            'password' => bcrypt('password')
        ]);
        $res = $this->post('/login', [
            'email' => 'user@giganotes.test',
            'password' => 'password'
        ]);
        $res->assertStatus(302);
        $res->assertRedirect('/dashboard');
    }

    public function test_cannot_access_app_single_user()
    {
        $res = $this->get('/dashboard');
        $res->assertStatus(302);
        $res->assertRedirect('/login');
    }
}
