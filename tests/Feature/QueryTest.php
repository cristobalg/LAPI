<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class QueryTest extends TestCase
{
    use DatabaseMigrations;

    public function testBasicTest()
    {
        $response = $this->get('/api/v1');
        $response->assertStatus(200)->assertJson([]);

        $response = $this->get('/api/v1?q=laravel');

        $response->assertStatus(200)->assertJson($response->json());
        $response->assertStatus(200)->assertSeeText('laravel');

    }
}
