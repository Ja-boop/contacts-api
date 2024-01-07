<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_user_auth(): void
    {
        $this->post('/api/login', [
            'email' => 'bad@email.com',
            'password' => 'password',
        ])->assertStatus(302);

        $this->post('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ])->assertStatus(200);

        $this->post('/api/logout')->assertStatus(200);
    }
}
