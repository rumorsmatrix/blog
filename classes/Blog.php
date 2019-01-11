<?php

namespace Rumorsmatrix\Blog;

class Blog {

	public static $configuration = [];
	public static $Poirot = NULL;
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

}
