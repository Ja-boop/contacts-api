<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        Storage::fake('public');

        $this->post('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ])->assertStatus(200);
    }

    public function test_get_all_by_user(): void
    {
        $this->get('/api/contact')->assertStatus(200)->assertJsonCount(2);
    }

    public function test_update(): void
    {
        $file = UploadedFile::fake()->image('new-avatar.jpg');
        $contactUrl = '/api/contact/1';
        $this->put($contactUrl, [
            'name' => 'Jane',
            'image' => $file
        ])->assertStatus(200);
        Storage::disk('public')->assertExists('images/' . $file->hashName());

        $this->get($contactUrl)->assertJson([
            'name' => 'Jane',
        ]);
    }

    public function test_create(): void
    {
        $file = UploadedFile::fake()->image('avatar.jpg');
        $response = $this->post('/api/contact', [
            'name' => 'John',
            'title' => 'Developer',
            'address' => '123 Main St',
            'email' => 'X5F5K@example.com',
            'phone' => '123-456-7890',
            'image' => $file

        ])->assertStatus(201);

        $contact = $response->decodeResponseJson()->json();
        Storage::disk('public')->assertExists('images/' . $file->hashName());
        $this->get('/api/contact/' . $contact['id'])->assertStatus(200);
    }
}
