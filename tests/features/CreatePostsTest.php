<?php

class CreatePostsTest extends FeatureTestCase
{
  function test_a_user_create_a_post()
  {
    //Having
    $this->actingAs($user = $this->defaultUser());

    //When
    $this->visit(route('posts.create'))
        ->type('Esta es una pregunta', 'title')
        ->type('Este es el contenido', 'content')
        ->press('Publicar');

    //Then
    $this->seeInDataBase('posts', [
      'title'   => 'Esta es una pregunta',
      'content' => 'Este es el contenido',
      'pending' => true,
      'user_id' => $user->id,
    ]);

    //Test a user redirected to the post details after creating it.
    $this->see('Esta es una pregunta');
  }

  function test_creating_a_post_requires_authentication()
  {
    $this->visit(route('posts.create'))
        ->seePageIs(route('login'));
  }

  function test_create_post_form_validation()
  {
    $this->actingAs($this->defaultUser())
        ->visit(route('posts.create'))
        ->press('Publicar')
        ->seePageIs(route('posts.create'))
        ->seeErrors([
          'title'   => 'El campo titulo es obligatorio.',
          'content' => 'El campo contenido es obligatorio.'
        ]);
  }

}
