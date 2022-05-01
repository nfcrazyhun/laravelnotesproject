<?php

namespace Tests\Feature\web;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_see_dashboard()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('dashboard'));

        $response
            ->assertOk()
            ->assertSee('You are logged in!');
    }
}
