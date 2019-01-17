<?php
// --- a "Page" is a single page of content, either a stand-alone page or a single entry

namespace Rumorsmatrix\Blog;
use Mustache_Engine;

class Page {

	protected $name;
	protected $params;
	protected $template;
	protected $type;
	protected $posts;
	public $content;


	public function __construct($name = '', $params = []) {
		$this->name = $name;
		$this->params = $params;
		$this->content = [];
		$this->template = 'default_page';

		if (!empty($this->params['post'])) {
			// single post view
			$this->type = 'single';
			$this->addPost($params['post']);

		} elseif (!empty($this->params['page']) && is_int($this->params['page'])) {
			// multiple post page view
			$this->type = 'multiple';

			// get all posts
			$directory_listing = Blog::getContentDirectory();

			// add these posts to the page
			foreach ($directory_listing as $file) {
				$this->addPost(substr($file, 0, strlen($file)-3), 'default_list');
			}
		}

		// try to infer a page name
		if (count($this->posts) === 1) {
			$this->name = ($this->posts[0]->getTitle()) ?: $this->name;
		}

	}


	private function addPost($post_slug, $template = 'default_post') {
		$new_post = new Post($post_slug);
		if ($new_post->hasContent() || $new_post->hasMetadata()) {
			$new_post->setTemplate($template);
			$this->posts[] = $new_post;
		}
	}


	public function render() {
		if (!empty($this->posts)) {

			foreach ($this->posts as $post) {
				$this->content[] = $post->render();
			}

			echo Blog::$Poirot->render($this->template,
				[
					'page_type' => [$this->type => $this->type],
					'template' => [$this->template => $this->template],
					'name' => $this->name,
					'post' => $this->content
				]
			);

		} else {
			// quoth the raven, 404
			Blog::sendHeader('404 Not Found');
		}
	}


}


