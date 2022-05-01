<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use App\Services\UserService;
use http\Client\Curl\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected UserService $userService;

    public function setUp(): void
    {
        parent::setUp();

        $this->userService = new UserService;
    }

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_cannot_register_without_invitation_code()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertGuest();
    }

    public function test_new_users_can_register_with_invitation_code()
    {
        $user = \App\Models\User::factory()->create();

        $pendingUser = $this->userService->createPendingUser($user->id);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'username' => 'tesuserke',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'invitation_code' => $pendingUser->invitation_code,
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
