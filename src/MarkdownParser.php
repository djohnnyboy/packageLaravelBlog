<?php


namespace Djohnnyboy\Poweredblog;

use Parsedown;

class MarkdownParser {
	
	public static function parse($string){

		return \Parsedown::instance()->text($string);
	}
}