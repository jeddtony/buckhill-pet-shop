<?php
namespace Tests;

use Tests\TestCase;
use App\Models\User;

class AuthenticatedTestCase extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
  
    }
}