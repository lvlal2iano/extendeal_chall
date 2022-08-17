<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Tests\TestCase;

class StatusTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->withHeaders(
            [
               'Accept' => 'application/json',
               'Content-Type' => 'application/json',
               'X-HTTP-USER-ID' => User::first()->id,
            ]
        );
    }

    /** @test */
    public function ver_status()
    {
         $response = $this->getJson('/api/v1/status');

         $response
         ->assertStatus(200)
         ->assertExactJson([
            'data' => [],
            'status' => 'success',
            'code' => '200',
            'errors' => ''
         ]);
    }
}
