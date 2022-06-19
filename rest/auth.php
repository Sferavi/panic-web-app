<?php
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;
require 'config.php';

class auth{
  public static function encode_jwt($token_data){
    $user_token = [
      'iat' => time(),
      'exp' => strtotime('+10 hours'),
      'data' => $token_data
    ];

    $jwt = JWT::encode($user_token, Config::JWT_SECRET,'HS256');

    return $jwt;
  }

  public static function decode_jwt($data){
    try{
      $jwt = explode("Bearer ", $data['Authorization'])[1];

      $user_data = (array) JWT::decode($jwt, new Key(Config::JWT_SECRET, 'HS256'));

      $user_data['data'] = (array) $user_data['data'];

      return $user_data;
    } catch (\Throwable $e) {
       Flight::halt(403, "Invalid token! Error: " . $e->getMessage());
    }
  }
}

 ?>
