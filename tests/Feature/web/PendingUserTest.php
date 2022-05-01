<?php

namespace Tests\Feature\web;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PendingUserTest extends TestCase
{
    protected User $user;
    protected UserService $userService;

    public function setUp(): void
    {
        parent::setUp(); //must call this first

        $this->user = User::factory()->create();
        $this->userService = new UserService;
    }

    /**
     * @test
     */
    public function test_user_can_see_pending_user_invitations()
    {
        $this->actingAs($this->user); //login as user

        $pendingUser = $this->userService->createPendingUser($this->user->id);

        //visit /users
        $response = $this->get(route('pending-users.index'));

        //check if everything went good
        $response
            ->assertOk()
            ->assertSee($pendingUser->invitation_code);
    }
}
