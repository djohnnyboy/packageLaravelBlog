<?php

namespace Djohnnyboy\Poweredblog\Tests;

use Djohnnyboy\Poweredblog\BlogFileParser;
use Carbon\Carbon;

class BlogFileParserTest extends TestCase {
	
	/** @test */
	public function head_body_split(){
		
		$fileParser = (new BlogFileParser(__DIR__.'/../blogs/MarkFile1.md'));
		$data = $fileParser->getRawData();

		$this->assertStringContainsString('title: My Title', $data[0][0]);
		$this->assertStringContainsString('description: Descritpion here', $data[1][0]);
		$this->assertStringContainsString('Blog post body here', $data[2][0]);
	}

	/** @test */
	public function pass_string_instead(){

		$fileParser = (new BlogFileParser("---\ntitle: My Title\n---\nBlog post body here"));
		$data = $fileParser->getRawData();

		$this->assertStringContainsString('title: My Title', $data[0][0]);
		$this->assertStringContainsString('Blog post body here', $data[2][0]);
	}

	/** @test */
	public function head_field_separated() {

		$fileParser = (new BlogFileParser(__DIR__.'/../blogs/MarkFile1.md'));
		$data = $fileParser->getData();

		$this->assertEquals('My Title', $data['title']);
		$this->assertEquals('Descritpion here', $data['description']);	
	}

	/** @test */
	public function body_saved_trimmed(){

		$fileParser = (new BlogFileParser(__DIR__.'/../blogs/MarkFile1.md'));
		$data = $fileParser->getData();

		$this->assertEquals("<h1>Heading</h1>\n<p>Blog post body here</p>", $data['body']);	
	}

	/** @test */
	public function date_field_parsed(){

		$fileParser = (new BlogFileParser("---\ndate: May 14, 1998\n---\n"));
		$data = $fileParser->getData();

		$this->assertInstanceOf(Carbon::class, $data['date']);
		$this->assertEquals('05/14/1998', $data['date']->format('m/d/Y'));
	}

	/** @test */
	public function extra_field_saved(){

		$fileParser = (new BlogFileParser("---\nauthor: John Doe\n---\n"));
		$data = $fileParser->getData();
		$this->assertEquals(json_encode(['author' => 'John Doe']), $data['extra']);
	}

	/** @test */

	public function additional_fields_into_extra(){

		$fileParser = (new BlogFileParser("---\nauthor: John Doe\n\rimage: some/image.jpg\n---\n"));
		$data = $fileParser->getData();
		$this->assertEquals(json_encode(['author' => 'John Doe', 'image' => 'some/image.jpg']), $data['extra']);	
	}
}