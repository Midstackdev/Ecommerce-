<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_requires_a_name()
    {
        $this->json('POST', 'api/auth/register')
            ->assertJsonValidationErrors(['name']);
    }

    public function test_it_requires_an_email()
    {
        $this->json('POST', 'api/auth/register')
            ->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_valid_email()
    {
        $this->json('POST', 'api/auth/register', ['email' => 'nope'])
            ->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_unique_email()
    {
        $user = factory(User::class)->create();

        $this->json('POST', 'api/auth/register', ['email' => $user->email])
            ->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_an_password()
    {
        $this->json('POST', 'api/auth/register')
            ->assertJsonValidationErrors(['password']);
    }

    public function test_it_registers_a_user()
    {
        $this->json('POST', 'api/auth/register', [
            'name' => $name = 'lfrdsmit',
            'email' => $email = 'lfrd@admin.com',
            'password' => 'secret'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $email,
            'name' => $name
        ]);
    }

    public function test_it_returns_a_user_on_regisration()
    {
        $this->json('POST', 'api/auth/register', [
            'name' => 'lfrdsmit',
            'email' => $email = 'lfrd@admin.com',
            'password' => 'secret'
        ])

        ->assertJsonFragment([
            'email' => $email,
        ]);
    }
}
