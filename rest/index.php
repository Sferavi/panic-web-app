<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS, PATCH');


require 'auth.php';
require 'Mail.php';
require 'NewRegistrationNotifier.php';
require 'Subject.php';
require_once('../vendor/autoload.php');
require_once('config.php');
require_once('dao/UsersDao.class.php');
require_once('dao/RecipeInfoDao.class.php');
require_once('dao/RecipeImageDao.class.php');
require_once('dao/CookbookInfoDao.class.php');
require_once('dao/CookbookImageDao.class.php');

Flight::register('user_dao', 'UsersDao');
Flight::register('recipe_info_dao', 'RecipeInfoDao');
Flight::register('recipe_image_dao', 'RecipeImageDao');
Flight::register('cookbook_info_dao', 'CookbookInfoDao');
Flight::register('cookbook_image_dao', 'CookbookImageDao');

Flight::route('GET /users', function () {
    $data      = apache_request_headers();
    $user_data = Auth::decode_jwt($data);
    if ($user_data['data']['admin'] == 0) {
        Flight::halt(403, 'It is allowed only for admin users');
    }
    $users = Flight::user_dao()->get_all();
    Flight::json($users);
});

Flight::route('GET /user', function () {
    $data      = apache_request_headers();
    $user_data = Auth::decode_jwt($data);
    $user      = Flight::user_dao()->get_user_by_id($user_data['data']['id']);
    Flight::json($user);
});

Flight::route('POST /users', function () {
    $subject = new Subject();
    $nrn = new NewRegistrationNotifier();
    $subject->attach($nrn);
    $user = Flight::request()->data->getData();
    Flight::user_dao()->add($user);
    $subject->someBusinessLogic(1, $user['username']);
    $subject->detach($nrn);
});

Flight::route('POST /login', function () {
    $user    = Flight::request()->data->getData();
    $db_user = Flight::user_dao()->get_user_by_username($user['username']);

    if ($db_user) {
        if ($db_user['password'] == $user['password']) {
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

Flight::route('DELETE /recipe/@id', function ($id) {
    Flight::recipe_info_dao()->delete_recipe($id);
});

Flight::route('DELETE /users/@id', function ($id) {
    Flight::user_dao()->delete_user($id);
});

Flight::route('GET /favorite_recipes', function () {
    $data      = apache_request_headers();
    $user_data = Auth::decode_jwt($data);
    $recipes   = Flight::recipe_info_dao()->get_all_favorite_recipes($user_data['data']['id']);
    Flight::json($recipes);
});

Flight::route('GET /recipe_images', function () {
    $recipe_images = Flight::recipe_image_dao()->get_all();
    Flight::json($recipe_images);
});

Flight::route('GET /recipes', function () {
    $recipes = Flight::recipe_info_dao()->get_all();
    Flight::json($recipes);
});

Flight::route('GET /myrecipes', function () {
    $data       = apache_request_headers();
    $user_data  = Auth::decode_jwt($data);
    $my_recipes = Flight::recipe_info_dao()->get_my_recipes($user_data['data']['id']);
    Flight::json($my_recipes);
});

Flight::route('GET /recipe/@id', function ($id) {
    $recipe = Flight::recipe_info_dao()->get_recipe_by_id($id);
    Flight::json($recipe);
});

Flight::route('POST /recipe_info', function () {
    $data                   = apache_request_headers();
    $user_data              = Auth::decode_jwt($data);
    $recipe_info            = Flight::request()->data->getData();
    $recipe_info['user_id'] = $user_data['data']['id'];
    Flight::recipe_info_dao()->add($recipe_info);
});

Flight::route('POST /recipe/@id', function ($id) {
    $recipe_info = Flight::request()->data->getData();
    Flight::recipe_info_dao()->update_recipe($recipe_info, $id);
});

Flight::route('GET /cookbook_images', function () {
    $cookbook_images = Flight::cookbook_image_dao()->get_all();
    Flight::json($cookbook_images);
});

Flight::route('GET /cookbooks', function () {
    $data         = apache_request_headers();
    $user_data    = Auth::decode_jwt($data);
    $my_cookbooks = Flight::cookbook_info_dao()->get_my_cookbooks($user_data['data']['id']);
    Flight::json($my_cookbooks);
});

Flight::route('GET /cookbook/@id', function ($id) {
    $cookbook = Flight::cookbook_info_dao()->get_cookbook_by_id($id);
    Flight::json($cookbook);
});

Flight::route('POST /cookbook/@id', function ($id) {
    $cookbook_info = Flight::request()->data->getData();
    Flight::cookbook_info_dao()->update_cookbook($cookbook_info, $id);
});

Flight::route('POST /cookbook_info', function () {
    $data                     = apache_request_headers();
    $user_data                = Auth::decode_jwt($data);
    $bookbook_info            = Flight::request()->data->getData();
    $bookbook_info['user_id'] = $user_data['data']['id'];
    Flight::cookbook_info_dao()->add($bookbook_info);
});

Flight::route('DELETE /cookbook/@id', function ($id) {
    Flight::cookbook_info_dao()->delete_cookbook($id);
});

Flight::start();
