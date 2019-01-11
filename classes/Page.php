<?php

// --- a "Page" is a single page of content, either a stand-alone page or a single entry

namespace Rumorsmatrix\Blog;
use Mustache_Engine;

class Page {

	protected $name;
	protected $params;
	protected $poirot;
	protected $template;
	protected $posts;
	public $content;


	public function __construct($name = '', $params = []) {
		$this->name = $name;
		$this->params = $params;
		$this->poirot = new Mustache_Engine(['escape' => function($value) {
			return is_array($value) ? $value[0] : $value;
		} ]);
		$this->template = $this->getTemplate();
		$this->content = [];

		// single post view
		if (!empty($this->params['post'])) {
			$this->addPost($params['post']);
			$this->addPost($params['post']);
			$this->addPost($params['post']);
		}
	}


	private function addPost($post_slug) {

		$new_post = new Post($post_slug);
		if ($new_post->content) {

			// parse metadata content, etc
			// ...

			// add to page
			$this->posts[] = $new_post;

		}
	}


        private function getTemplate() {
                $filename = "../templates/default_page.mustache";
                if (file_exists($filename)) {
                        return file_get_contents($filename);
                } else {
                        throw new \Exception("Couldn't find page template!");
                }
        }


	private function getMustacheContext() {
		$context = array_merge(
			[
				'post' => $this->content

			],
			Blog::$configuration
		);
		return $context;
	}



	public function render() {

		if (!empty($this->posts)) {

			foreach ($this->posts as $post) {
				$this->content[] = $post->render();
			}

			echo $this->poirot->render($this->template, $this->getMustacheContext());



		} else {
			// quoth the raven, 404
			Blog::sendHeader('404 Not Found');
		}
	}
}


