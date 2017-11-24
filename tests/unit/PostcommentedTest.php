<?php

use App\{Comment, User};
use App\Notifications\PostCommented;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Notifications\Messages\MailMessage;

class PostcommentedTest extends TestCase
{
  use DatabaseTransactions;

  /**
   * @test
   */
  function it_builds_a_mail_massage()
  {
    $comment = factory(Comment::class)->create();

    $notification = new PostCommented($comment);

    $subscriber = factory(User::class)->create();

    $message = $notification->toMail($subscriber);

    $this->assertInstanceOf(MailMessage::class, $message);

    $this->assertSame(
      "Nuevo comentario en: {$comment->post->title}",
      $message->subject
    );

    $this->assertSame(
      "{$comment->user->last_name} {$comment->user->firts_name} escribio un comentario en: {$comment->post->title}",
      $message->introLines[0]
    );

    $this->assertSame(
      $comment->post->url,
      $message->actionUrl
    );

  }
}
