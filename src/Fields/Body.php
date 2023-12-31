<?php

namespace Djohnnyboy\Poweredblog\Fields;

use Djohnnyboy\Poweredblog\MarkdownParser;

class Body extends FieldContract {

	public static function process($type, $value, $data){
		return [
			//$type => MarkdownParser::parse($value),
			'it is' => 'working'
		];
	}
} 