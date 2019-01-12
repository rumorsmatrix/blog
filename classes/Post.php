<?php

// --- a "Post" is a single unit of content, many of which may make up a page

namespace Rumorsmatrix\Blog;
use Parsedown;


class Post {

	protected $content;
	protected $metadata;
	protected $file_contents;
	protected $template;

	public function __construct($slug) {
		$this->slug = $slug;
		$this->template = 'default_post';

		$this->file_contents = $this->getFile($slug);
		$this->parseFile();
	}


	public function setTemplate($new_template) {
		$this->template = $new_template;
	}


	private function getFile($slug) {
		$filename = Blog::$configuration['content_path'] . $slug . ".md";
		if (file_exists($filename)) {
			return file($filename);
		} else {
			return false;
		}
	}


	private function parseFile() {
		if (empty($this->file_contents)) return false;

		// does this file start with some metadata?
		if (trim($this->file_contents[0]) === "{") {

			// look for the end of the metadata
			$metadata_end_line = 0;
			foreach ($this->file_contents as $line_index => $line) {
				if ($line === "}\n") {
					$metadata_end_line = $line_index;
					break;
				}
			}

			if ($metadata_end_line) {
				$metadata = implode("\n", array_slice($this->file_contents, 0, $metadata_end_line+1));
				$this->metadata = json_decode($metadata, true);
				$this->file_contents = array_slice($this->file_contents, $metadata_end_line+1);
			}
		}

		$this->metadata['slug'] = $this->slug;

		$pd = new Parsedown();
		$this->content = $pd->text(implode("\n", $this->file_contents));
	}


	public function hasContent() {
		return (!empty($this->content));
	}


	public function hasMetadata() {
		return (!empty($this->metadata));
	}


	public function getTitle() {
		return (!empty($this->metadata['title'])) ? $this->metadata['title'] : false;
	}

	public function getTags() {
		return (!empty($this->metadata['tags']['values'])) ? $this->metadata['tags']['values'] : [];
	}


	public function render() {
		return Blog::$Poirot->render($this->template, ['content' => $this->content, 'metadata' => $this->metadata]);
	}

}


