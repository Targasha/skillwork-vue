<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic login test.
     *
     * @return void
     */
    public function test_login()
    {
        $data = [
            'email' => 'taner.ahmedov84@gmail.com',
            'password' => 'secret'
        ];

        $this->json('POST', '/api/login', $data, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token', 'token_type', 'expires_at', 'user'
            ]);
    }
}
