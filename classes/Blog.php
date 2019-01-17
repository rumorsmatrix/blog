<?php

namespace Rumorsmatrix\Blog;

class Blog {

	public static $configuration = [];
	public static $Poirot = NULL;
	public static $tags = [];
	public $handler = NULL;

	public function __construct($config_file = '../config/default.json') {

		// load configuration
		if (file_exists($config_file)) {
			$config_contents = file_get_contents($config_file);
			if (!$config_contents) throw new \Exception('Could not read from configuration file!');

			$config_json = json_decode($config_contents, TRUE);
			if (is_null($config_json)) throw new \Exception('Could not decode configuration JSON!');

			static::$configuration = $config_json;


		} else {
			throw new \Exception('Configuration file is missing!');
		}


		static::getAllTags();
		static::$Poirot = new Poirot();

	}


	public function setHandler($route_match) {

		$class = "\Rumorsmatrix\Blog\\" . $route_match['target'];

		if (class_exists($class)) {
			$this->handler = new $class($route_match['name'], $route_match['params']);

		} else {
			throw new \Exception('Unable to find a class to handle route!');
		}
	}


	static function sendHeader($message) {
		header( $_SERVER["SERVER_PROTOCOL"] . ' ' . $message);
		die();
	}


	static function getContentDirectory() {

		// fetch directory listing
		$directory_listing = scandir(static::$configuration['content_path']);

		// filter listing
		foreach ($directory_listing as $index => $file) {
			// we only want files in the format yyyy-mm-dd-slug-format-text
			$regex = "/^[\d]{4}-[\d]{2}-[\d]{2}(-?)([\w-])*\.md/";
			if (preg_match($regex, $file) === 0) unset($directory_listing[$index]);
		}

		// natural sort, reindex what's left so they're in reverse date order (latest first)
		natsort($directory_listing);
		$directory_listing = array_values($directory_listing);
		$directory_listing = array_reverse($directory_listing);

		return $directory_listing;
	}


	private function getAllTags() {
		$all_files = static::getContentDirectory();
		foreach ($all_files as $file) {
			$slug = substr($file, 0, strlen($file)-3);
			$post = new Post($slug);
			$tags = $post->getTags();
			static::registerTags($slug, $tags);
		}

		// okay, now we're going to jump through some wierd hoops to format this for Mustache
		$tag_array = [];
		foreach(static::$tags as $tag => $slug_array) {
			$tag_array[] = [
				'name' => $tag,
				'count' => count($slug_array),
				'slugs' => $slug_array
			];
		}

		// sort so the highest count tags are first
		usort($tag_array, function($a, $b) {
			return ($a['count'] > $b['count']) ? -1 : 1;
		});

		static::$tags = $tag_array;

	}


	private function registerTags(string $slug, array $tags) {
		foreach ($tags as $tag) {
			if (!isset(static::$tags[$tag])) static::$tags[$tag] = [];
			if(!in_array($slug, static::$tags[$tag])) static::$tags[$tag][] = $slug;
		}
	}

}
