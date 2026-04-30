<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_user()
    {
        User::create([
            'name' => 'Budi',
            'email' => 'budi@test.com',
            'password' => bcrypt('password'),
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'budi@test.com',
        ]);
    }
}
