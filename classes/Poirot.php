<?php

// --- kind of a helper/wrapper for dealing with Mustache based things

namespace Rumorsmatrix\Blog;
use Mustache_Engine;
use Mustache_Loader_FilesystemLoader;

class Poirot {

	public function __construct() {
		$this->Mustache = new Mustache_Engine([
			'loader' => new Mustache_Loader_FilesystemLoader(Blog::$configuration['templates_path']),
			'escape' => function($value) { return is_array($value) ? $value[0] : $value; }
		]);
	}


	private function buildMustacheContext($provided_context) {
		if (!is_array($provided_context)) $provided_context = [$provided_context];

		$context = array_merge(
			$provided_context,
			Blog::$configuration
		);

		return $context;
	}


	public function render($template, $context) {
		return $this->Mustache->render($template, $this->buildMustacheContext($context));
	}

}


