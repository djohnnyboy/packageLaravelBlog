<?php

namespace Djohnnyboy\Poweredblog;

//use Djohnnyboy\Poweredblog\MarkdownParser;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Support\Str;
use ReflectionClass;

class BlogFileParser {

	protected $filename;
	protected $data;
	protected $rawData;

	public function __construct($filename){

		$this->filename = $filename;
		$this->splitFile();
		$this->explode_data();
		$this->processFields();
	}

	public function getData(){

		return $this->data;
	}

	public function getRawData(){

		return $this->rawData;
	}

	protected function splitFile(){

		preg_match_all('/^\-{3}(.*?)\-{3}(.*)/s', 
			File::exists($this->filename) ? File::get($this->filename) : $this->filename, 
			$this->rawData
		);
	}

	protected function explode_data(){

		foreach (explode("\r", trim($this->rawData[1][0])) as $fieldString) {
			preg_match('/(.*):\s?(.*)/', $fieldString, $fieldArray);
			$this->data[$fieldArray[1]] = $fieldArray[2];
		};
		$this->data['body'] = trim($this->rawData[2][0]);
	}

	protected function processFields() {

		foreach ($this->data as $field => $value) {	

			$class = $this->getField(Str::title($field));
			
			if (! class_exists($class) && ! method_exists($class, 'process')) {
				$class = 'Djohnnyboy\\Poweredblog\\Fields\\Extra';
			}		

			$this->data = array_merge(
				$this->data, 
				$class::process($field, $value, $this->data)
			);
		}
	}

	private function getField($field){

		foreach (\Djohnnyboy\Poweredblog\Facades\Blog::availableFields() as $avalField) {
			$class = new ReflectionClass($avalField);

			if ($class->getShortName() == $field) {
				return $class->getName();	
			}
		}	
	}
}
