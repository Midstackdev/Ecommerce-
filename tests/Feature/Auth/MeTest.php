<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_fails_if_user_isnt_authenticated()
    {
        $this->json('GET', 'api/auth/me')
            ->assertStatus(401);
    }


    public function test_returns_user_details()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'GET', 'api/auth/me')
            ->assertJsonFragment([
                'email' => $user->email
            ]);
    }
}
