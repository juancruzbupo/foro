<?php

namespace App\Http\Controllers;

use App\{User, Token};
use Illuminate\Http\Request;

class RegisterController extends Controller
{
  function create()
  {
    return view('register/create');
  }

  function store(Request $request)
  {
    $this->validate($request, [
      'email'       =>  'required|email|unique:users',
      'username'    =>  'required',
      'first_name'  =>  'required',
      'last_name'   =>  'required',
    ]);

    $user = User::create($request->all());

    Token::generateFor($user)->sendByEmail();

    return redirect('register/confirmation');

  }

  function confirmation()
  {
    return view('register.confirmation');
  }

}
