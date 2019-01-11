<?php

// --- a "Post" is a single unit of content, many of which may make up a page

namespace Rumorsmatrix\Blog;

class Post {

	public $content;	// content needs to be public so Mustache can see it


	public function __construct($slug) {
		$this->content = $this->getContent($slug);
	}


	private function getContent($slug) {
		$filename = "../content/" . $slug . ".md";
		if (file_exists($filename)) {
			return file_get_contents($filename);
		} else {
			return false;
		}
	}


	public function render() {
		return Blog::$Poirot->render('default_post', ['content' => $this->content]);
	}

}


