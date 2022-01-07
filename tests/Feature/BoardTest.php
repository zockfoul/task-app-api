<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class BoardTest extends TestCase
{
    /**
     * @test
     */
    public function user_can_get_all_boards(): void
    {
        $this->actingAs(User::find(1));
        $this->withoutExceptionHandling();

        $response = $this->json('GET', route('api.boards.all'));

        $response->assertJson(fn (AssertableJson $json) => $json
            ->has('links', fn (AssertableJson $json) => $json->hasAll('first', 'last', 'prev', 'next'))
            ->has('meta', fn (AssertableJson $json) => $json->hasAll('current_page', 'from', 'last_page', 'links', 'path', 'per_page', 'to', 'total')
            ->has('links.0', fn (AssertableJson $json) => $json->hasAll('url', 'label', 'active')))
            ->has('data.0', fn (AssertableJson $json) => $json->hasAll('id', 'name', 'hex_color', 'author_id', 'author_full_name')
            ->whereAllType([
                'id' => 'integer',
                'name' => 'string',
                'hex_color' => 'string',
                'author_id' => 'integer',
                'author_full_name' => 'string',
            ])
            )
        )->assertStatus(200);
    }

    /**
     * @test
     */
    public function user_cannot_get_boards_without_authorization(): void
    {
        $this->actingAs(User::find(10));

        $response = $this->json('GET', route('api.boards.all'));

        $response->assertStatus(403);
    }
}