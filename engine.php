<?php

// composer autoloader and namespace set-up
require __DIR__ . '/vendor/autoload.php';
namespace Rumorsmatrix\Blog;
use AltoRouter;
use Mustache_Engine;


// create configuration
$config = [
	'base_path' => "blog/",
];


// initialise routing
$router = new AltoRouter();
$router->setBasePath($config['base_path']);


// map routes
$router->map('GET', '/', function() { echo "hello world!"; }, 'home');
$router->map('GET', '/post/[:post]?', 'Post', 'single post view');


// match this request
$match = $router->match();


if($match && is_callable($match['target'])) {
	call_user_func_array( $match['target'], $match['params']);
} else {
	// no route was matched
	header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}

