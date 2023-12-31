<?php

namespace Djohnnyboy\Poweredblog;

use Illuminate\Support\Str;

class Blog {

	protected $fields = [];

	public function configNotPublished(){
		
		return is_null(config('blog'));
	}

	public function driver(){

		$driver = Str::title(config('blog.driver'));
		$class = "Djohnnyboy\Poweredblog\Drivers\\" . $driver . "Driver";
		
		return new $class;	
	}

	public function path(){
		return config('blog.path', 'blogs');
	}

	public function fields(array $fields){

		$this->fields = array_merge($this->fields, $fields);
	}

	public function availableFields(){
		
		return $this->fields;
	}

}