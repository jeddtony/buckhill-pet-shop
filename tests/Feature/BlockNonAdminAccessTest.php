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
     * Test that a non-admin can not view list of users
     *
     * @return void
     */
    public function testNonAdminCannotViewUsers() {

        $response = $this->get('api/v1/admin/user-listing');

        $response->assertStatus(401);
    }
}
