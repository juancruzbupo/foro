<?php

use Illuminate\Support\Facades\Notification;

class WriteCommentTest extends FeatureTestCase
{
    function test_a_user_can_write_a_comment()
    {
      Notification::fake();

      $post = $this->createPost();

      $this->actingAs($this->defaultUser())
          ->visit($post->url)
          ->type('Un comentario', 'comment')
          ->press('Publicar comentario');

      $this->seeInDatabase('comments', [
        'comment' => 'Un comentario',
        'user_id' => $this->defaultUser()->id,
        'post_id' => $post->id,
      ]);

      $this->seePageIs($post->url);
    }

    function test_create_comment_form_validation()
    {
      $post = $this->createPost();

      $this->actingAs($this->defaultUser())
          ->visit($post->url)
          ->press('Publicar comentario');

      $this->seePageIs($post->url)
          ->seeErrors([
            'comment' => 'El campo comentario es obligatorio',
          ]);
    }
}
