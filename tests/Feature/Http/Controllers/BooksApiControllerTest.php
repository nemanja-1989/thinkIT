<?php

namespace Tests\Feature\Http\Controllers;

use App\Helpers\PermissionConstants;
use App\Helpers\RoleConstants;
use App\Http\Controllers\BooksApiController;
use App\Models\Book;
use App\Models\User;
use App\Repositories\BookRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Mockery\MockInterface;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class BooksApiControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_books_index_return_status(): void
    {
        $user = User::first();
        $response = $this->actingAs($user)
            ->getJson('/api/books');
        $response
            ->assertStatus(200)
            ->assertJson($response->json());
    }
}
