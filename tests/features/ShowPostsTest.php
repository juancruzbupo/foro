<?php

class ShowPostsTest extends FeatureTestCase
{
    function test_a_user_can_see_the_post_details()
    {
        //Having

        $user = $this->defaultUser();

        $post = factory(\App\Post::class)->make([ //create guarda en la base de datos y make crea pero no lo guarda
          'title'   => 'Este es el titulo del Post.',
          'content' => 'Este es el contenido del Post.',
        ]);

        $user->posts()->save($post);

        //when
        $this->visit(route('posts.show', $post))
            ->seeInElement('h1', $post->title)
            ->see($post->content)
            ->see($user->name);

    }
}
