<?php


namespace Djohnnyboy\Poweredblog\Drivers;

use Illuminate\Support\Facades\File;
use Djohnnyboy\Poweredblog\BlogFileParser;
use Djohnnyboy\Poweredblog\Exceptions\FileDriverDirNotFoundException;

class FileDriver extends Driver{

	public function __construct(){

	}

	public function fetchPosts(){

		$files = File::files(config('blog.path'));

		foreach ($files as $file) {
			$this->posts[] = $this->parse($file->getPathname(), $file->getFilename());
		};
		return $this->posts;
	}

	protected function validateSource() {
		
		if (! File::exists($this->config['path'])) {  
			throw new FileDriverDirNotFoundException("Directory at \\" . $this->config['path'] . "\\ doesnt exist. Check the directory path in config file."
			);				
		}
	}
}