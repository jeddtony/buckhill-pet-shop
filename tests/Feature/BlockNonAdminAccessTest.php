<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class BlockNonAdminAccessTest extends TestCase
{
    protected $user;
    // setup admin user
    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($this->user, 'api');
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
     * Test that a non-admin can not view list of users
     *
     * @return void
     */
    public function testNonAdminCannotViewUsers() {

        $response = $this->get('api/v1/admin/users');

        $response->assertStatus(401);
    }
}
