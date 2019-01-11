<?php

// composer autoloader and namespace set-up
namespace Rumorsmatrix\Blog;
require __DIR__ . '/vendor/autoload.php';
use AltoRouter;
use Mustache_Engine;


// create application instance (which initialises configuration)
$blog = new Blog();


// initialise routing
$router = new AltoRouter();
$router->setBasePath(Blog::$configuration['base_path']);


// map routes
$router->map('GET', '/', 'Page', 'home');
$router->map('GET', '/post/[:post]?', 'Page', 'single post-page view');


// match this request
if ($match = $router->match()) {

	if (is_callable($match['target'])) {
		call_user_func_array( $match['target'], $match['params']);

	} else {
		$blog->setHandler($match);
		if (!is_null($blog->handler)) $blog->handler->render();
	}

} else {
	// quoth the raven, 404
	Blog::sendHeader('404 Not Found');
}

