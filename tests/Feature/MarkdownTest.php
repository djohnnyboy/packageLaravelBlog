<?php

namespace Djohnnyboy\Poweredblog\Tests;

use Djohnnyboy\Poweredblog\MarkdownParser;

class MarkdownTest extends TestCase {

	/** @test */
	public function markdown_parsed(){
		$this->assertEquals('<h1>Heading</h1>', MarkdownParser::parse('# Heading'));
	}
}