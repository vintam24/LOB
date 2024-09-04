<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UnitTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    public function test_example(): void
    {
        $response = $this->postJson('/api/unit-testing');
        $response->assertStatus(200);
        $this->assertDatabaseHas('rekap_klaim', ['LOB' => 'KUR']);
    }
}
