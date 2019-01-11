# rumorsmatrix/blog

A simple(?) PHP blog for my own personal use, but feel free to clone it and have a laugh.


## Requires

* Composer
* [AltoRouter](https://github.com/dannyvankooten/AltoRouter)
* [Mustache.php](https://github.com/bobthecow/mustache.php)
* [php-markdown](https://github.com/michelf/php-markdown)


## Installation

Clone this repo and let composer do it's stuff. Symlink the `public` directory to somewhere 
your webserver can serve. Use the provided `.htaccess` or do whatever you need to make all
your requests point at `public/index.php`.

Investigate the `config/default.json` file.


## Usage

Put your content in the `content/` directory. Filenames should be in the format
`yyyy-mm-dd-title-slug.md`. Open the document with a JSON object describing your metadata, thus:

```
{
        "title": "A test page",
        "datetime": "2019-01-11 20:00:00",
        "tags": {"values": ["hello", "world"] }
}
```

Below that, write your actual content in Markdown. Individual posts are served from 
`/posts/yyyy-mm-dd-title-slug`.
