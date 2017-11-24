<?php

namespace App\Http\Controllers;

use App\{User, Token};
use Illuminate\Http\Request;

class LoginController extends Controller
{
  function create()
  {
    return view('login.create');
  }

  function store(Request $request)
  {
    $this->validate($request, [
      'email'   => 'required|email|exists:users',
    ]);

    $user = User::where('email', $request->get('email'))->first();

    Token::generateFor($user)->sendByEmail();

    alert('Enviamos a tu email un enlace para que inicie sesion');

    return back();
    //return redirect()->route('login_confirmation');

  }
}
