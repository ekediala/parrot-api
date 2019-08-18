<?php

namespace Tests\Unit;

use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Test bad login.
     *
     * @return void
     */
    public function testBadLogin()
    {
        $response = $this
            ->json('POST', '/api/login', ['email' => 'Sally', 'password' => 'password']);
        $response->assertStatus(401);

    }

    /**
     * Test correct login.
     *
     * @return void
     */
    public function testGoodLogin()
    {
        $response = $this
            ->json('POST', '/api/login', ['email' => 'devenyinna@gmail.com', 'password' => 'password']);
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['success']);

    }
}
