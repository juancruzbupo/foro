<?php
use App\Comment;

class SupportMarkdownTest extends FeatureTestCase
{
  function test_the_post_content_support_markdown()
  {
    $importantText = 'Un texto muy importante';

    $post = $this->createPost([
      'content' => "La primera parte del texto . **$importantText**. La ultima parte del texto"
    ]);

    $this->visit($post->url)
        ->seeInElement('strong', $importantText);
  }

  function test_xss_attack($value='')
  {
    $xssAttack = "<script>alert('malicius JS!')</script>";

    $post = $this->createPost([
      'content' => "$xssAttack. Texto normal"
    ]);

    $this->visit($post->url)
        ->dontSee($xssAttack)
        ->seeText($xssAttack);
  }

  function test_xss_attack_with_html($value='')
  {
    $xssAttack = "<img src='img.jpg'></img>";

    $post = $this->createPost([
      'content' => "$xssAttack. Texto normal"
    ]);

    $this->visit($post->url)
        ->dontSee($xssAttack);
  }

  function test_the_comment_post_support_markdown()
  {
    $importantText = "Texto importante";

    $comment = factory(Comment::class)->create([
      'comment' => "Primer parte del texto. **$importantText**. Segunda parte del texto"
    ]);

    $this->visit($comment->post->url)
        ->seeInElement('strong', $importantText);
  }
}
