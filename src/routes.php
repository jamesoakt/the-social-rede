<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/login','LoginController@signin');
$router->get('/cadastro', 'LoginController@signup');
$router->post('/login','LoginController@signinAction');  //diferença entre post e get 



//testando commit 