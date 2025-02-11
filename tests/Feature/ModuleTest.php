<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Module;


class ModuleTest extends TestCase
{
    use RefreshDatabase;

    public function testModuleCreation()
    {
        $data = [
            'width' => '100px',
            'height' => '200px',
            'color' => '#ff0000',
            'link' => 'https://example.com',
        ];

        $response = $this->postJson('/modules', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('modules', $data);
    }

    public function testModuleDownload()
    {
        $module = Module::factory()->create([
            'width' => '100px',
            'height' => '200px',
            'color' => '#ff0000',
            'link' => 'https://example.com',
        ]);

        $response = $this->get("/modules/{$module->id}/download");

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/zip');
    }

    public function testInvalidModuleCreation()
    {
        $invalidData = [
            'width' => 'invalid',
            'height' => '200px',
            'color' => 'wrongcolor',
            'link' => 'invalid-url',
        ];

        $response = $this->postJson('/modules', $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['width', 'color', 'link']);
    }
}
