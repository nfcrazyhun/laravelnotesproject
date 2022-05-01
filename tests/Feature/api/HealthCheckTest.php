<?php

namespace Tests\Feature\api;

use Tests\ApiTester;

class HealthCheckTest extends ApiTester
{
    /**
     * A basic test example.
     *
     */
    public function test_health_check()
    {
        $response = $this->getJson(route('api.v1.test'));

        $response
            ->assertStatus(418)
            ->assertJson([
                "response" => [
                    "message" => "I'm a teapot",
                    "status_code" => 418,
                ]
            ]);
    }
}
