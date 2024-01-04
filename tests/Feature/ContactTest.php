<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

use function PHPUnit\Framework\assertTrue;

class ContactTest extends TestCase
{
    public function test_user_creation_and_edition(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('avatar.jpg');

        $loginResponse = $this->post('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);
        $loginResponse->assertStatus(200);

        $createdContactResponse = $this->post('/api/contact', [
            'name' => 'John',
            'title' => 'Developer',
            'address' => '123 Main St',
            'email' => 'X5F5K@example.com',
            'phone' => '123-456-7890',
            'image' => $file

        ]);

        $createdContact = $createdContactResponse->decodeResponseJson()->json();
        $createdContactResponse->assertStatus(201);
        Storage::disk('public')->assertExists('images/' . $file->hashName());

        $contactResponse = $this->get('/api/contact/' . $createdContact['id']);
        $contactResponse->assertStatus(200);
        $contactResponse->assertJson(
            fn (AssertableJson $json) =>
            $json->where('id', $createdContact['id'])->etc()
        );

        $updateContactResponse = $this->put('/api/contact/' . $createdContact['id'], [
            'name' => 'Jane',
        ]);
        $updateContactResponse->assertStatus(200);
        print_r($updateContactResponse->decodeResponseJson()->json());

        $updatedContactResponse = $this->get('/api/contact/' . $createdContact['id']);
        $updatedContactResponse->assertStatus(200);
        $updatedContactResponse->assertJson(
            fn (AssertableJson $json) =>
            $json->where('name', 'Jane')->etc()
        );
    }
}
