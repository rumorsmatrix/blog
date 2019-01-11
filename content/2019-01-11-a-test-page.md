{
	"title": "A test page",
	"datetime": "2019-01-11 20:00:00",
	"tags": {"values": ["hello", "world"] } 
}

This is the content of the file, woo yay.


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

