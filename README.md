# rumorsmatrix/blog engine

A simple(?) PHP blog for my own personal use, but feel free to clone it and have a laugh.


## Requires

* Composer
* [AltoRouter](https://github.com/dannyvankooten/AltoRouter)
* [Mustache.php](https://github.com/bobthecow/mustache.php)


## Installation

Clone this repo and let composer do it's stuff. Symlink the `public` directory to somewhere 
your webserver can serve. Use the provided `.htaccess` or do whatever you need to make all
your requests point at `public/index.php` _except_ requests with a period (`.`) in them; 
those will be served directly from the `public` directory -- this covers front-end stuff like
images, stylesheets and the like.




