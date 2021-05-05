<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_success_index()
    {
        $user = User::find(1);
        $token = $user->createToken('TestToken')->accessToken;

        $method = 'GET';
        $url = '/api/articles';
        $data = [];
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->json($method, $url, $data, $headers)
            ->assertStatus(200);

        $response->assertJson(
            fn (AssertableJson $json) => $json->first(
                fn ($json) => $json->where('id', 1)
                     ->where('title', 'Test')
                     ->etc()
            )
        );
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_success_store()
    {
        $user = User::find(1);
        $token = $user->createToken('TestToken')->accessToken;

        $method = 'POST';
        $url = '/api/articles';
        $data = [
            'title' => 'Test 4',
            'content' => 'test 4'
        ];
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->json($method, $url, $data, $headers)
            ->assertStatus(201);

        $response
            ->assertJson(
                fn (AssertableJson $json) => $json->where('title', 'Test 4')
                    ->where('content', 'test 4')
                    ->etc()
            );
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_success_show()
    {
        $user = User::find(1);
        $token = $user->createToken('TestToken')->accessToken;

        $method = 'GET';
        $url = '/api/articles/1';
        $data = [];
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->json($method, $url, $data, $headers)
            ->assertStatus(200);

        $response
            ->assertJson(
                fn (AssertableJson $json) => $json->where('id', 1)
                    ->where('title', 'Test')
                    ->where('content', 'test')
                    ->where('user_id', $user->id)
                    ->etc()
            );
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_success_update()
    {
        $user = User::find(1);
        $token = $user->createToken('TestToken')->accessToken;

        $method = 'PUT';
        $url = '/api/articles/2';
        $data = [
            'title' => 'Test 2 updated',
            'content' => 'test 2 updated'
        ];
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->json($method, $url, $data, $headers)
            ->assertStatus(200);

        $response
            ->assertJson(
                fn (AssertableJson $json) => $json->where('id', 2)
                    ->where('title', 'Test 2 updated')
                    ->where('content', 'test 2 updated')
                    ->where('user_id', $user->id)
                    ->etc()
            );
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_success_destroy()
    {
        $user = User::find(1);
        $last_article = $user->articles->last();

        $token = $user->createToken('TestToken')->accessToken;

        $method = 'DELETE';
        $url = '/api/articles/' . $last_article->id;
        $data = [];
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->json($method, $url, $data, $headers)
            ->assertStatus(204);
    }
}
