<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS, PATCH');


require 'auth.php';
require_once('../vendor/autoload.php');
require_once('config.php');
require_once('dao/UsersDao.class.php');
require_once('dao/RecipeInfoDao.class.php');


Flight::register('user_dao', 'UsersDao');
Flight::register('recipe_info_dao', 'RecipeInfoDao');

Flight::route('GET /users', function(){
    $data = apache_request_headers();
    $user_data = Auth::decode_jwt($data);
    if($user_data['data']['admin']==0){
            Flight::halt(403, 'It is allowed only for admin users');
        }
    $users = Flight::user_dao()->get_all();
    Flight::json($users);
});

Flight::route('POST /users', function(){
    $users = Flight::request()->data->getData();
    Flight::user_dao()->add($users);
});

Flight::route('POST /login', function(){
  $user = Flight::request()->data->getData();
  $db_user = Flight::user_dao()->get_user_by_username($user['username']);

  if($db_user){
    if($db_user['password'] == $user['password']){
      $token_data = [
        'id' => $db_user['id'],
        'username' => $db_user['username'],
        'admin' => $db_user['admin']
      ];
      $jwt = Auth::encode_jwt($token_data);
      Flight::json(['user_token' => $jwt]);
    } else {
      Flight::halt(404, 'Password is not correct');
    }
  } else {
    Flight::halt(404, 'User not found');
  }
});

Flight::route('POST /recipe_info', function(){
  $recipe_info = Flight::request()->data->getData();
  Flight::recipe_info_dao()->add($recipe_info);
});

Flight::route('DELETE /users/@id', function($id){
  Flight::user_dao()->delete_user($id);
});

Flight::start();
?>
