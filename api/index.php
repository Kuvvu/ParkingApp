<?php
error_reporting(E_ALL ^ E_NOTICE);
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require 'vendor/autoload.php';
$settings = [
 'settings' => [
 'displayErrorDetails' => DEBUG,
 ]
];
$app = new \Slim\App($settings);
$app->add(new \CorsSlim\CorsSlim());

  $app->group('/v1', function(){
    $this->get('/bs', '\Parking\Load:bs');
    $this->get('/zh', '\Parking\Load:zh');
    $this->get('/sg', '\Parking\Load:sg');
    $this->get('/lu', '\Parking\Load:lu');
    $this->get('/be', '\Parking\Load:be');
    $this->get('/zg', '\Parking\Load:zg');
  });

$app->run();
