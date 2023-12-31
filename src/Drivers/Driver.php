<?php

namespace Djohnnyboy\Poweredblog\Drivers;

use Djohnnyboy\Poweredblog\BlogFileParser;

use Illuminate\Support\Str;

abstract class Driver {

	protected $posts = [];
	protected $config;

	public function __construct(){

		$this->setConfig();
		$this->validateSource();
	}

	public abstract function fetchPosts();

	protected function setConfig(){

		$this->config = config('blog'. config('blog.driver'));
	}

	protected function validateSource() {
		
		return true;
	}

	protected function parse($content, $identifier){
		
		$this->posts[] = array_merge(
			(new BlogFileParser($content))->getData(),
			['identifier' => Str::slug($identifier)]
		);
	}
}