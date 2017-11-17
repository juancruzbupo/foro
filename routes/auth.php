<?php

//Post
Route::get('posts/create', [
  'uses'  => 'CreatePostsController@create',
  'as'    => 'posts.create'
]);

Route::post('posts/create', [
  'uses'  => 'CreatePostsController@store',
  'as'    => 'posts.store'
]);