<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminMiddlewareTest extends TestCase
{
    // setup admin user
    public function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create([
            'is_admin' => true
        ]);

        $this->actingAs($this->admin, 'api');
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test that an admin can view list of users
     *
     * @return void
     */
    public function testAdminCanViewListOfUsers() {
        $response = $this->get('api/v1/admin/users');

        $response->assertStatus(200);
    }
}
