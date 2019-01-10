<?php

namespace Rumorsmatrix\Blog;
use Mustache_Engine;
require __DIR__ . '/vendor/autoload.php';


$m = new Mustache_Engine;
echo $m->render('Hello {{planet}}', array('planet' => "World!\n")); // "Hello World!"


$b = new Blog;
