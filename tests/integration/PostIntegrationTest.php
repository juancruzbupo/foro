<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostIntegrationTest extends TestCase
{
  use DatabaseTransactions;

  function test_a_slug_in_generated_and_saved_to_the_database()
  {
    $post = $this->createPost([
      'title' => 'Como instalar laravel'
    ]);

    $this->assertSame(
      'como-instalar-laravel',
      $post->fresh()->slug
    );

    /*
    $this->seeInDatabase('posts', [
      'slug' => 'como-instalar-laravel',
    ]);

    $this->assertSame('como-instalar-laravel', $post->slug);
    */

  }
}
