<?php

// --- a "Page" is a single page of content, either a stand-alone page or a single entry

namespace Rumorsmatrix\Blog;
use Mustache_Engine;

class Page {

	protected $name;
	protected $params;
	protected $template;
	protected $posts;
	public $content;


	public function __construct($name = '', $params = []) {
		$this->name = $name;
		$this->params = $params;
		$this->content = [];
		$this->template = 'default_page';

		// single post view
		if (!empty($this->params['post'])) {
			$this->addPost($params['post']);
		}
	}


	private function addPost($post_slug) {

		$new_post = new Post($post_slug);
		if ($new_post->content) {
			$this->posts[] = $new_post;
		}
	}


	public function render() {
		if (!empty($this->posts)) {

			foreach ($this->posts as $post) {
				$this->content[] = $post->render();
			}

			echo Blog::$Poirot->render($this->template, ['post' => $this->content]);

		} else {
			// quoth the raven, 404
			Blog::sendHeader('404 Not Found');
		}
	}


}


