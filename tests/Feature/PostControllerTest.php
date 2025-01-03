<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Post;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_post()
    {
        $response = $this->postJson('/api/posts', [
            'title' => 'New Post',
            'content' => 'This is the content of the new post.',
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'title' => 'New Post',
                     'content' => 'This is the content of the new post.',
                 ]);
    }

    /** @test */
    public function it_fetches_all_posts()
    {
        $post = Post::factory()->create();

        $response = $this->getJson('/api/posts');

        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => $post->title]);
    }

    /** @test */
    public function it_updates_a_post()
    {
        $post = Post::factory()->create();

        $response = $this->putJson("/api/posts/{$post->id}", [
            'title' => 'Updated Title',
            'content' => 'Updated content for the post.',
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'title' => 'Updated Title',
                     'content' => 'Updated content for the post.',
                 ]);
    }

    /** @test */
    public function it_deletes_a_post()
    {
        $post = Post::factory()->create();

        $response = $this->deleteJson("/api/posts/{$post->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Post deleted successfully']);
    }
}
