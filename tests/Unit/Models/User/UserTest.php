<?php

namespace Tests\Unit\Models\User;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_hasshes_the_password_when_creating()
    {
        $user = factory(User::class)->create([
        	'password' => 'cats'
        ]);

        $this->assertNotEquals($user->password, 'cats');
    }
}
