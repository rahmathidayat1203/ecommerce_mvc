<?php

$router = new Router('ecommerce_mvc');

$router->add('GET', '/', 'HomeController@index')
       ->get('products', 'ProductsController@index')
       ->get('products/show/{id}', 'ProductsController@show')
       ->get('products/create','ProductsController@create')
       ->post('products/store','ProductsController@store')
       ->run();

// $router->add('GET', '/', function () {
//        echo "Hello, this is the homepage!";
// });
// $router->run();

// Handle request dengan router
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
