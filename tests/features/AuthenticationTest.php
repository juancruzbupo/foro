<?php

use App\Token;
use App\Mail\TokenMail;

class AuthenticationTest extends FeatureTestCase
{

  function test_a_guest_user_can_request_a_token()
  {
    Mail::fake();

    $user = $this->defaultUser(['email' => 'admin@styde.net']);

    $this->visitRoute('login')
        ->type('admin@styde.net', 'email')
        ->press('Solicitar token');

    $token = Token::where('user_id', $user->id)->first();

    $this->assertNotNull($token);

    Mail::assertSentTo($user, TokenMail::class, function ($mail) use ($token)
    {
      return $mail->token->id == $token->id;
    });

    $this->dontSeeIsAuthenticated();

    $this->see('Enviamos a tu email un enlace para que inicie sesion');
  }

  function test_a_guest_user_can_request_a_token_without_an_email()
  {

    $this->visitRoute('login')
        ->press('Solicitar token');

    $this->seeErrors([
      'email' => 'El campo correo electrónico es obligatorio'
    ]);
  }

  function test_a_guest_user_can_request_a_token_an_invalid_email()
  {
    $this->visitRoute('login')
        ->type('silence', 'email')
        ->press('Solicitar token');

    $this->seeErrors([
      'email' => 'Correo electrónico no es un correo válido'
    ]);
  }

  function test_a_guest_user_can_request_a_token_with_a_non_existent_email()
  {
    $user = $this->defaultUser(['email' => 'admin@styde.net']);

    $this->visitRoute('login')
        ->type('silence@styde.net', 'email')
        ->press('Solicitar token');

    $this->see('Correo electrónico es inválido');
  }

}
