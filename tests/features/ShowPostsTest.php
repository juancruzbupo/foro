<?php

class ShowPostsTest extends FeatureTestCase
{
    function test_a_user_can_see_the_post_details()
    {
      //Having
      $user = $this->defaultUser([
        'name' => 'Bupo Juan',
      ]);

      $post = $this->createPost([ //create guarda en la base de datos y make crea pero no lo guarda
        'title'   => 'Este es el titulo del Post.',
        'content' => 'Este es el contenido del Post.',
        'user_id' => $user->id,
      ]);

      //when
      $this->visit($post->url)
          ->seeInElement('h1', $post->title)
          ->see($post->content)
          ->see('Bupo Juan');

    }

    function test_old_urls_are_redirectes()
    {

      $post = $this->createPost([
        'title'   => 'Old Title.',
      ]);

      $url = $post->url;

      $post->update(['title' => 'New Title']);

      //when
      $this->visit($url)
          ->seePageIs($post->url);

    }
}
