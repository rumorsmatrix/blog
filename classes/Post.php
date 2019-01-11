<?php

// --- a "Post" is a single unit of content, many of which may make up a page

namespace Rumorsmatrix\Blog;
use Mustache_Engine;

class Post {

	public $content;	// content needs to be public so Mustache can see it
	public $rendered_content;
	protected $template;
	protected $poirot;


	public function __construct($slug) {
		$this->content = $this->getContent($slug);
		$this->template = $this->getTemplate();

		$this->poirot = new Mustache_Engine;
		$this->render();
	}


	private function getContent($slug) {
		$filename = "../content/" . $slug . ".md";
		if (file_exists($filename)) {
			return file_get_contents($filename);
		} else {
			return false;
		}
	}


	private function getTemplate() {
		$filename = "../templates/default_post.mustache";
		if (file_exists($filename)) {
			return file_get_contents($filename);
		} else {
			throw new \Exception("Couldn't find post template!");
		}
	}


	public function render() {
		return $this->poirot->render($this->template, $this);
	}

}


