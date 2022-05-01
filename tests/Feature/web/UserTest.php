<?php

namespace Tests\Feature\web;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    protected User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /**
     * @test
     */
    public function test_auth_user_can_see_users_under_his_hierarchy()
    {
        $this->actingAs($this->user); //login as user

        //create some user in hierarchy
        $user1 = User::factory()->create(['parent_id' => $this->user->id]);
        $user2 = User::factory()->create(['parent_id' => $user1->id]);

        //visit /users
        $response = $this->get(route('users.index'));

        //check if everything went good
        $response
            ->assertOk()
            ->assertSee($user1->username)
            ->assertSee($user2->username)
        ;

    }
}
