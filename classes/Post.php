<?php

// --- a "Post" is a single unit of content, many of which may make up a page

namespace Rumorsmatrix\Blog;
use Michelf\Markdown;


class Post {

	public $content;
	public $metadata;
	protected $file_contents;


	public function __construct($slug) {
		$this->file_contents = $this->getFile($slug);
		$this->parseFile();
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
		if (!isset($this->file_contents)) return false;

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

print_r($this->metadata);

			}
		}

		$this->content = Markdown::defaultTransform(implode("\n", $this->file_contents));
	}


	public function render() {
		return Blog::$Poirot->render('default_post', ['content' => $this->content, 'metadata' => $this->metadata]);
	}

}


